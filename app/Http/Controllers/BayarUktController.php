<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\BiayaPmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        
        // Log konfigurasi untuk debugging
        Log::info('BayarUktController initialized', [
            'server_key_exists' => !empty(config('midtrans.server_key')),
            'client_key_exists' => !empty(config('midtrans.client_key')),
            'is_production' => config('midtrans.is_production', false)
        ]);
    }

    /**
     * Halaman pembayaran (dengan modal)
     */
    public function index()
    {
        $user = Auth::user();
        
        Log::info('BayarUktController@index accessed', [
            'user_id' => $user->id,
            'is_ukt_paid' => $user->is_ukt_paid,
            'is_bayar_pendaftaran' => $user->is_bayar_pendaftaran
        ]);

        // Jika sudah bayar, redirect ke dashboard
        if ($user->is_ukt_paid) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah menyelesaikan pembayaran Semester.');
        }

        // Ambil biaya ukt
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
            ->first();

        if (!$biaya) {
            Log::error('Biaya UKT tidak ditemukan', [
                'user_id' => $user->id,
                'kodeProdi' => $user->kodeProdi_1,
                'tahun' => date('Y')
            ]);
            return back()->with('error', 'Biaya semester belum tersedia untuk program studi Anda.');
        }

        $biaya_ukt = $biaya->biaya_ukt;
        
        Log::info('Biaya UKT ditemukan', [
            'biaya_ukt' => $biaya_ukt,
            'prodi' => $user->kodeProdi_1
        ]);

        return view('bayar.index', compact('user', 'biaya_ukt'));
    }

    public function store(Request $request)
    {
        Log::info('========== UKT STORE METHOD CALLED ==========');
        
        $user = Auth::user();
        
        Log::info('User data for UKT payment', [
            'user_id' => $user->id,
            'email' => $user->email,
            'is_ukt_paid' => $user->is_ukt_paid,
            'is_bayar_pendaftaran' => $user->is_bayar_pendaftaran
        ]);

        if ($user->is_ukt_paid) {
            Log::warning('User already paid UKT', ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan pembayaran UKT.'
            ], 400);
        }

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
            ->first();

        if (!$biaya) {
            Log::error('Biaya UKT not found in store method', [
                'user_id' => $user->id,
                'kodeProdi' => $user->kodeProdi_1
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Biaya semester tidak ditemukan.'
            ], 404);
        }

        $jumlah = $biaya->biaya_ukt;
        
        Log::info('UKT Amount determined', [
            'jumlah' => $jumlah,
            'biaya_id' => $biaya->id
        ]);

        // Cek payment yang sudah settlement
        $settledPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'ukt')
            ->where('status_transaksi', 'settlement')
            ->first();

        if ($settledPayment) {
            Log::info('UKT payment already settled', [
                'payment_id' => $settledPayment->id,
                'order_id' => $settledPayment->order_id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran UKT Anda sudah diverifikasi.'
            ], 400);
        }

        // Cek payment yang masih pending dan belum expire (< 24 jam)
        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'ukt')
            ->where('status_transaksi', 'pending')
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if ($pendingPayment) {
            // Gunakan payment yang masih pending
            $orderId = $pendingPayment->order_id;
            Log::info('Using existing pending UKT payment', [
                'order_id' => $orderId,
                'created_at' => $pendingPayment->created_at
            ]);
        } else {
            // PERBAIKAN PENTING: Pastikan prefix UNIK untuk UKT
            $orderId = 'PMB-UKT-' . $user->id . '-' . time();
            
            Log::info('Creating new UKT payment', [
                'order_id' => $orderId,
                'jumlah' => $jumlah,
                'user_id' => $user->id
            ]);
            
            try {
                $payment = Payment::create([
                    'user_id'          => $user->id,
                    'order_id'         => $orderId,
                    'jumlah'           => $jumlah,
                    'tipe_pembayaran'  => 'ukt', // HARUS 'ukt' bukan 'pendaftaran'
                    'status_transaksi' => 'pending',
                ]);
                
                Log::info('UKT Payment record created successfully', [
                    'payment_id' => $payment->id,
                    'order_id' => $payment->order_id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create UKT payment record', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat record pembayaran: ' . $e->getMessage()
                ], 500);
            }
        }

        try {
            Log::info('Attempting to generate Snap Token for UKT', [
                'order_id' => $orderId,
                'amount' => $jumlah
            ]);
            
            $snapToken = $this->generateSnapToken($user, $jumlah, $orderId);
            
            Log::info('Snap Token generated successfully for UKT', [
                'order_id' => $orderId,
                'token_exists' => !empty($snapToken)
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'amount' => $jumlah,
                'message' => 'Token berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            Log::error('❌ UKT Midtrans Snap Token Error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'order_id' => $orderId,
                'amount' => $jumlah,
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // PERBAIKAN: Handle error lebih spesifik
            $errorMessage = 'Gagal membuat transaksi pembayaran UKT. ';
            
            if (strpos($e->getMessage(), 'order_id') !== false || 
                strpos($e->getMessage(), 'already exists') !== false) {
                
                Log::warning('Duplicate order_id detected for UKT', ['order_id' => $orderId]);
                
                // Hapus payment yang baru dibuat jika bukan pending payment lama
                if (!$pendingPayment) {
                    Payment::where('order_id', $orderId)->delete();
                    Log::info('Deleted duplicate UKT payment record', ['order_id' => $orderId]);
                }
                
                // Generate order_id baru dengan random string
                $newOrderId = 'PMB-UKT-' . $user->id . '-' . time() . '-' . substr(md5(uniqid()), 0, 8);
                
                Log::info('Creating new UKT payment with different order_id', [
                    'old_order_id' => $orderId,
                    'new_order_id' => $newOrderId
                ]);
                
                try {
                    // Buat payment baru
                    Payment::create([
                        'user_id'          => $user->id,
                        'order_id'         => $newOrderId,
                        'jumlah'           => $jumlah,
                        'tipe_pembayaran'  => 'ukt',
                        'status_transaksi' => 'pending',
                    ]);
                    
                    // Coba generate token lagi
                    $snapToken = $this->generateSnapToken($user, $jumlah, $newOrderId);
                    
                    Log::info('Retry successful for UKT payment', ['new_order_id' => $newOrderId]);
                    
                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'order_id' => $newOrderId,
                        'message' => 'Token berhasil dibuat setelah retry'
                    ]);
                } catch (\Exception $e2) {
                    Log::error('UKT Midtrans Retry Error: ' . $e2->getMessage());
                    $errorMessage .= 'Error retry: ' . $e2->getMessage();
                }
            } else {
                $errorMessage .= 'Error: ' . $e->getMessage();
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Generate Snap Token untuk UKT
     */
    private function generateSnapToken($user, $amount, $orderId)
    {
        Log::info('Generating Snap Token for UKT', [
            'order_id' => $orderId,
            'amount' => $amount,
            'user_email' => $user->email
        ]);
        
        if (empty($orderId)) {
            throw new \Exception('Order ID tidak boleh kosong');
        }
        
        if ($amount <= 0) {
            throw new \Exception('Jumlah pembayaran UKT tidak valid: ' . $amount);
        }
        
        // Validasi amount sebagai integer
        $amount = (int) $amount;
        if ($amount <= 1000) {
            throw new \Exception('Amount UKT terlalu kecil: ' . $amount);
        }
        
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'item_details' => [
                [
                    'id'       => 'UKT-' . date('Y-m') . '-' . $user->id, // UNIK untuk UKT
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => 'Biaya UKT Semester 1 - ' . date('Y'), // Nama jelas UKT
                ]
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '081234567890',
            ],
            'enabled_payments' => [
                'gopay',
                'shopeepay', 
                'qris',
                'bank_transfer',
                'echannel',
                'bca_klikpay',
                'bca_klikbca',
                'bri_epay',
                'cimb_clicks',
                'credit_card',
            ],
            'callbacks' => [
                'finish' => route('payment.finish') . '?type=ukt', // Tambahkan parameter type
            ],
        ];
        
        Log::info('Snap Token Params for UKT', [
            'order_id' => $orderId,
            'amount' => $amount,
            'item_name' => $params['item_details'][0]['name'],
            'callback_url' => $params['callbacks']['finish']
        ]);
        
        try {
            // Test koneksi ke Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            
            Log::info('Midtrans Config for UKT', [
                'server_key_first_10' => substr(config('midtrans.server_key'), 0, 10) . '...',
                'is_production' => config('midtrans.is_production'),
                'client_key' => substr(config('midtrans.client_key'), 0, 10) . '...'
            ]);
            
            $snapToken = Snap::getSnapToken($params);
            
            if (empty($snapToken)) {
                throw new \Exception('Snap Token kosong dari Midtrans');
            }
            
            Log::info('Snap Token successfully generated for UKT', [
                'token_length' => strlen($snapToken),
                'order_id' => $orderId
            ]);
            
            return $snapToken;
            
        } catch (\Exception $e) {
            Log::error('Failed to generate Snap Token for UKT', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'midtrans_config' => [
                    'server_key_set' => !empty(config('midtrans.server_key')),
                    'client_key_set' => !empty(config('midtrans.client_key'))
                ]
            ]);
            throw $e;
        }
    }

    /**
     * Webhook dari Midtrans untuk UKT
     */
    public function webhook(Request $request)
    {
        Log::info('========== UKT WEBHOOK RECEIVED ==========', [
            'order_id' => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
            'timestamp' => now()
        ]);

        try {
            $serverKey = config('midtrans.server_key');
            
            // Log untuk debugging signature
            Log::info('UKT Webhook Signature Calculation', [
                'order_id' => $request->order_id,
                'status_code' => $request->status_code,
                'gross_amount' => $request->gross_amount,
                'server_key_exists' => !empty($serverKey)
            ]);
            
            $hashed = hash('sha512', 
                $request->order_id . 
                $request->status_code . 
                $request->gross_amount . 
                $serverKey
            );

            Log::info('UKT Signature Verification', [
                'calculated' => $hashed,
                'received' => $request->signature_key,
                'match' => ($hashed === $request->signature_key)
            ]);

            if ($hashed !== $request->signature_key) {
                Log::error('❌ Invalid Midtrans Signature for UKT');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $notif = new Notification();
            $payment = Payment::where('order_id', $notif->order_id)->first();

            if (!$payment) {
                Log::error('❌ UKT Payment not found: ' . $notif->order_id);
                return response()->json(['message' => 'UKT Payment not found'], 404);
            }

            Log::info('UKT Payment found', [
                'payment_id' => $payment->id,
                'tipe_pembayaran' => $payment->tipe_pembayaran,
                'current_status' => $payment->status_transaksi
            ]);

            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status ?? '';

            Log::info('Processing UKT payment', [
                'order_id' => $notif->order_id,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus,
                'payment_type' => $notif->payment_type
            ]);

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->updateUktPaymentSuccess($payment, $notif);
                } elseif ($fraudStatus == 'challenge') {
                    $payment->update([
                        'status_transaksi' => 'challenge',
                        'payload' => json_encode($notif->getResponse()),
                    ]);
                    Log::info('UKT Payment challenged', ['order_id' => $payment->order_id]);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->updateUktPaymentSuccess($payment, $notif);
            } elseif ($transactionStatus == 'pending') {
                $payment->update([
                    'status_transaksi' => 'pending',
                    'payload' => json_encode($notif->getResponse()),
                ]);
                Log::info('UKT Payment pending', ['order_id' => $payment->order_id]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $payment->update([
                    'status_transaksi' => $transactionStatus,
                    'payload' => json_encode($notif->getResponse()),
                ]);
                Log::info('UKT Payment ' . $transactionStatus, ['order_id' => $payment->order_id]);
            }

            Log::info('✅ UKT Webhook processed successfully', [
                'order_id' => $payment->order_id,
                'new_status' => $payment->status_transaksi
            ]);

            return response()->json(['message' => 'UKT Notification processed'], 200);

        } catch (\Exception $e) {
            Log::error('🔥 UKT Webhook Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Error processing UKT webhook'], 500);
        }
    }

    /**
     * Update payment UKT menjadi success
     */
    private function updateUktPaymentSuccess($payment, $notif)
    {
        Log::info('Updating UKT payment to success', [
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'old_status' => $payment->status_transaksi
        ]);
        
        $payment->update([
            'status_transaksi' => 'settlement',
            'id_transaksi'     => $notif->transaction_id,
            'payload'          => json_encode($notif->getResponse()),
        ]);

        $user = User::find($payment->user_id);
        if ($user && !$user->is_ukt_paid) {
            $user->is_ukt_paid = true;
            $user->save();

            Log::info('✅ User UKT status updated successfully', [
                'user_id' => $user->id,
                'order_id' => $payment->order_id,
                'is_ukt_paid' => $user->is_ukt_paid,
                'is_bayar_pendaftaran' => $user->is_bayar_pendaftaran
            ]);
            
            // Kirim notifikasi
            $this->sendUktSuccessNotification($user->id, $payment);
        } else {
            Log::info('User UKT already paid or user not found', [
                'user_id' => $payment->user_id,
                'already_paid' => $user ? $user->is_ukt_paid : 'user_not_found'
            ]);
        }
    }
    
    /**
     * Kirim notifikasi sukses UKT
     */
    private function sendUktSuccessNotification($userId, $payment)
    {
        try {
            // Pastikan model Notif di-import di atas
            \App\Models\Notif::create([
                'user_id' => $userId,
                'title' => 'Pembayaran UKT Berhasil!',
                'message' => 'Pembayaran UKT Semester 1 sebesar Rp ' . 
                           number_format($payment->jumlah, 0, ',', '.') . 
                           ' telah berhasil diverifikasi.',
                'is_read' => false
            ]);
            
            Log::info('UKT success notification sent', ['user_id' => $userId]);
        } catch (\Exception $e) {
            Log::error('Failed to send UKT notification: ' . $e->getMessage());
        }
    }

    /**
     * Halaman finish setelah pembayaran UKT
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');
        $type = $request->query('type', 'ukt'); // Default untuk UKT

        Log::info('UKT Finish page accessed', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'type' => $type
        ]);

        $payment = null;
        if ($orderId) {
            $payment = Payment::where('order_id', $orderId)->first();
            
            if ($payment) {
                Log::info('Payment found on finish page', [
                    'payment_id' => $payment->id,
                    'tipe_pembayaran' => $payment->tipe_pembayaran,
                    'status' => $payment->status_transaksi
                ]);
                
                // Jika settlement, update user status
                if ($payment->status_transaksi === 'settlement' && $payment->tipe_pembayaran === 'ukt') {
                    $user = $payment->user;
                    if ($user && !$user->is_ukt_paid) {
                        $user->is_ukt_paid = true;
                        $user->save();
                        Log::info('User UKT status updated from finish page', ['user_id' => $user->id]);
                    }
                }
            }
        }

        return view('bayar.finish', compact('payment', 'transactionStatus', 'type'));
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
            Log::warning('User already paid UKT trying to upload manual', ['user_id' => $user->id]);
            return back()->with('info', 'Anda sudah menyelesaikan pembayaran UKT.');
        }

        try {
            $path = $request->file('bukti_bayar')->store('bukti-pembayaran-ukt', 'public');
            
            Payment::create([
                'user_id'          => $user->id,
                'order_id'         => 'MANUAL-UKT-' . $user->id . '-' . time(), // UNIK untuk UKT
                'jumlah'           => $request->jumlah,
                'tipe_pembayaran'  => 'ukt', // PASTIKAN 'ukt'
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
     * Callback untuk testing
     */
    public function callback(Request $request)
    {
        Log::info('UKT Callback received', ['data' => $request->all()]);
        
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        Log::info('UKT Callback processing', [
            'order_id' => $orderId,
            'status' => $transaction,
            'type' => $type
        ]);

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::error('UKT Order not found in callback', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Pastikan ini payment UKT
        if ($payment->tipe_pembayaran !== 'ukt') {
            Log::warning('Callback received for non-UKT payment', [
                'order_id' => $orderId,
                'tipe' => $payment->tipe_pembayaran
            ]);
        }

        if ($transaction == 'capture' || $transaction == 'settlement') {
            $payment->status_transaksi = 'settlement';

            // UPDATE TABLE USERS JIKA SETTLEMENT
            $user = $payment->user;
            if ($user && $payment->tipe_pembayaran === 'ukt') {
                $user->is_ukt_paid = true;
                $user->save();
                Log::info('UKT User status updated via callback', ['user_id' => $user->id]);
            }

        } elseif ($transaction == 'pending') {
            $payment->status_transaksi = 'pending';
        } elseif ($transaction == 'deny') {
            $payment->status_transaksi = 'deny';
        } elseif ($transaction == 'expire') {
            $payment->status_transaksi = 'expire';
        } elseif ($transaction == 'cancel') {
            $payment->status_transaksi = 'cancel';
        }

        $payment->save();

        Log::info('UKT Callback processed', [
            'order_id' => $orderId,
            'new_status' => $payment->status_transaksi
        ]);

        return response()->json(['message' => 'UKT Callback processed']);
    }
    
    /**
     * API untuk check status UKT payment
     */
    public function checkStatus(Request $request)
    {
        $orderId = $request->query('order_id');
        $type = $request->query('type', 'ukt');
        
        Log::info('UKT Check status API called', [
            'order_id' => $orderId,
            'type' => $type
        ]);
        
        $payment = Payment::where('order_id', $orderId)
            ->where('tipe_pembayaran', 'ukt')
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            Log::warning('UKT Payment not found in checkStatus', ['order_id' => $orderId]);
            return response()->json([
                'status' => 'not_found',
                'message' => 'Payment not found or not authorized'
            ], 404);
        }

        return response()->json([
            'status' => $payment->status_transaksi,
            'is_ukt_paid' => $payment->user->is_ukt_paid ?? false,
            'order_id' => $payment->order_id,
            'amount' => $payment->jumlah
        ]);
    }
}