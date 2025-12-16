<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\BiayaPmb;
use App\Models\ProgramStudi;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class BayarUktController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
        
        Log::info('BayarUktController initialized', [
            'server_key_exists' => !empty(config('midtrans.server_key')),
            'client_key_exists' => !empty(config('midtrans.client_key')),
            'is_production' => config('midtrans.is_production', false)
        ]);
    }

    /**
     * Halaman pembayaran UKT
     */
    public function index()
    {
        $user = Auth::user();
        
        Log::info('BayarUktController@index accessed', [
            'user_id' => $user->id,
            'is_ukt_paid' => $user->is_ukt_paid
        ]);

        // Jika sudah bayar, redirect ke dashboard
        if ($user->is_ukt_paid) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah menyelesaikan pembayaran UKT.');
        }

        // Ambil biaya ukt
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->first();

        if (!$biaya) {
            Log::error('Biaya UKT tidak ditemukan', [
                'user_id' => $user->id,
                'kodeProdi' => $user->pilihan_1,
                'tahun' => date('Y')
            ]);
            return back()->with('error', 'Biaya UKT belum tersedia untuk program studi Anda.');
        }

        $biaya_ukt = $biaya->biaya_ukt;
        
        Log::info('Biaya UKT ditemukan', [
            'biaya_ukt' => $biaya_ukt,
            'prodi' => $user->pilihan_1
        ]);

        return view('bayar.ukt', compact('user', 'biaya_ukt'));
    }

    /**
     * Generate Snap Token untuk UKT (dipanggil via AJAX)
     */
    public function store(Request $request)
    {
        Log::info('========== UKT STORE METHOD CALLED ==========');
        
        $user = Auth::user();
        
        Log::info('User data for UKT payment', [
            'user_id' => $user->id,
            'pilihan_1' => $user->pilihan_1,
            'is_ukt_paid' => $user->is_ukt_paid
        ]);

        if ($user->is_ukt_paid) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan pembayaran UKT.'
            ], 400);
        }

        // PERBAIKAN: Gunakan pilihan_1 bukan kodeProdi_1
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->first();

        if (!$biaya) {
            Log::error('Biaya UKT not found', [
                'user_id' => $user->id,
                'pilihan_1' => $user->pilihan_1,
                'tahun' => date('Y')
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Biaya UKT tidak ditemukan untuk prodi: ' . $user->pilihan_1
            ], 404);
        }

        $jumlah = $biaya->biaya_ukt;
        
        if (!$jumlah || $jumlah <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Biaya UKT belum diset untuk program studi Anda.'
            ], 404);
        }

        // Generate order_id baru
        $orderId = 'PMB-UKT-' . $user->id . '-' . time() . '-' . substr(uniqid(), -4);
        
        try {
            $payment = Payment::create([
                'user_id'          => $user->id,
                'order_id'         => $orderId,
                'jumlah'           => $jumlah,
                'tipe_pembayaran'  => 'ukt',
                'status_transaksi' => 'pending',
            ]);
            
            Log::info('UKT Payment record created', ['payment_id' => $payment->id]);
            
        } catch (\Exception $e) {
            Log::error('Failed to create UKT payment', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat record pembayaran.'
            ], 500);
        }

        try {
            $snapToken = $this->generateSnapToken($user, $jumlah, $orderId);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'amount' => $jumlah
            ]);

        } catch (\Exception $e) {
            Log::error('UKT Midtrans Error: ' . $e->getMessage());
            
            // Hapus payment yang gagal
            Payment::where('order_id', $orderId)->delete();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Snap Token untuk UKT
     */
    private function generateSnapToken($user, $amount, $orderId)
    {
        if (empty($orderId)) {
            throw new \Exception('Order ID tidak boleh kosong');
        }
        
        if ($amount <= 0) {
            throw new \Exception('Jumlah pembayaran UKT tidak valid: ' . $amount);
        }
        
        $amount = (int) $amount;
        
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'item_details' => [
                [
                    'id'       => 'UKT-' . date('Y-m') . '-' . $user->id,
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => 'Biaya UKT Semester 1 - ' . date('Y'),
                ]
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap ?? $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '081234567890',
            ],
            'enabled_payments' => [
                'gopay', 'shopeepay', 'qris', 'bank_transfer', 'echannel',
                'bca_klikpay', 'bca_klikbca', 'bri_epay', 'cimb_clicks', 'credit_card',
            ],
            'callbacks' => [
                'finish' => route('payment.finish') . '?type=ukt',
            ],
        ];
        
        Log::info('Snap Token Params for UKT', [
            'order_id' => $orderId,
            'amount' => $amount
        ]);
        
        return Snap::getSnapToken($params);
    }

    /**
     * Upload bukti transfer manual UKT
     */
    public function uploadBukti(Request $request)
    {
        Log::info('UKT Manual upload started');
        
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jumlah' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->is_ukt_paid) {
            return back()->with('info', 'Anda sudah menyelesaikan pembayaran UKT.');
        }

        try {
            $path = $request->file('bukti_bayar')->store('bukti-pembayaran-ukt', 'public');
            
            Payment::create([
                'user_id'          => $user->id,
                'order_id'         => 'MANUAL-UKT-' . $user->id . '-' . time(),
                'jumlah'           => $request->jumlah,
                'tipe_pembayaran'  => 'ukt',
                'status_transaksi' => 'manual-upload',
                'bukti_manual'     => $path,
            ]);
            
            Log::info('UKT Manual upload successful', [
                'user_id' => $user->id,
                'path' => $path
            ]);

            return redirect()->route('mahasiswa.dashboard')
                ->with('success', 'Bukti pembayaran UKT berhasil diupload. Menunggu verifikasi admin.');
                
        } catch (\Exception $e) {
            Log::error('UKT Manual upload failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return back()->with('error', 'Gagal upload bukti pembayaran: ' . $e->getMessage());
        }
    }
    
    /**
     * API untuk check status UKT payment
     */
    public function checkStatus(Request $request)
    {
        $orderId = $request->query('order_id');
        
        Log::info('UKT Check status API called', ['order_id' => $orderId]);
        
        $payment = Payment::where('order_id', $orderId)
            ->where('tipe_pembayaran', 'ukt')
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Payment not found'
            ], 404);
        }

        // Jika settlement, pastikan user status terupdate dan generate NIM
        if ($payment->status_transaksi === 'settlement') {
            $user = $payment->user;
            if ($user && !$user->is_ukt_paid) {
                // Generate NIM jika belum ada
                if (empty($user->nim)) {
                    $nim = $this->generateNIM($user);
                    if ($nim) {
                        $user->nim = $nim;
                        Log::info('NIM generated for user', [
                            'user_id' => $user->id,
                            'nim' => $nim
                        ]);
                    }
                }
                
                $user->is_ukt_paid = true;
                $user->save();
            }
        }

        return response()->json([
<<<<<<< HEAD
            'status' => 'not_found',
            'message' => 'Payment not found or not authorized'
        ], 404);
=======
            'status' => $payment->status_transaksi,
            'is_ukt_paid' => $payment->user->is_ukt_paid ?? false,
            'nim' => $payment->user->nim ?? null,
            'order_id' => $payment->order_id,
            'amount' => $payment->jumlah
        ]);
>>>>>>> DashboardAdminCoba
    }

    /**
     * Generate NIM otomatis
     * Format: 226 + kodeProdi + nomor urut (3 digit)
     */
    private function generateNIM($user)
    {
        try {
            return DB::transaction(function () use ($user) {
                // Ambil kode prodi dari tabel program_studis
                $prodi = ProgramStudy::where('kodeProdi', $user->pilihan_1)->first();
                
                if (!$prodi) {
                    Log::error('Program Studi tidak ditemukan', [
                        'user_id' => $user->id,
                        'kodeProdi' => $user->pilihan_1
                    ]);
                    return null;
                }
                
                $kodeProdi = $prodi->kodeProdi;
                
                // Hitung jumlah mahasiswa yang sudah bayar UKT di prodi yang sama
                // Gunakan lockForUpdate untuk menghindari race condition
                $count = User::where('pilihan_1', $user->pilihan_1)
                    ->where('is_ukt_paid', true)
                    ->whereNotNull('nim')
                    ->lockForUpdate()
                    ->count();
                
                // Nomor urut dimulai dari 001
                $nomorUrut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
                
                // Format NIM: 226 + kodeProdi + nomor urut
                $nim = '226' . $kodeProdi . $nomorUrut;
                
                Log::info('NIM generated successfully', [
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'kodeProdi' => $kodeProdi,
                    'nomorUrut' => $nomorUrut,
                    'count' => $count
                ]);
                
                return $nim;
            });
            
        } catch (\Exception $e) {
            Log::error('Error generating NIM', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}