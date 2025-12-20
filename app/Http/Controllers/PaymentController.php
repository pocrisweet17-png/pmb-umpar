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
use App\Models\Notif;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Halaman pembayaran pendaftaran
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_bayar_pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah menyelesaikan pembayaran pendaftaran.');
        }

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->first();

        if (!$biaya) {
            return back()->with('error', 'Biaya pendaftaran belum tersedia untuk program studi Anda.');
        }

        $biaya_pendaftaran = $biaya->biaya_pendaftaran;

        return view('bayar.index', compact('user', 'biaya_pendaftaran'));
    }

    /**
     * Generate Snap Token untuk pembayaran pendaftaran (AJAX)
     */
    public function store(Request $request)
    {
        Log::info('Store method called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);
        $user = Auth::user();

        Log::info('Payment store called', ['user_id' => $user->id]);

        if ($user->is_bayar_pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan pembayaran pendaftaran.'
            ], 400);
        }

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->first();

        if (!$biaya) {
            return response()->json([
                'success' => false,
                'message' => 'Biaya pendaftaran tidak ditemukan.'
            ], 404);
        }

        $jumlah = $biaya->biaya_pendaftaran;

        // Cek payment yang sudah settlement
        $settledPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'pendaftaran')
            ->where('status_transaksi', 'settlement')
            ->first();

        if ($settledPayment) {
            // Update user status jika belum
            if (!$user->is_bayar_pendaftaran) {
                $user->is_bayar_pendaftaran = true;
                $user->save();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran Anda sudah diverifikasi.'
            ], 400);
        }

        // Generate order_id baru dengan timestamp yang lebih unik
        $orderId = 'PMB-PD-' . $user->id . '-' . time() . '-' . substr(uniqid(), -4);
        
        // Buat payment record
        $payment = Payment::create([
            'user_id'          => $user->id,
            'order_id'         => $orderId,
            'jumlah'           => $jumlah,
            'tipe_pembayaran'  => 'pendaftaran',
            'status_transaksi' => 'pending',
        ]);

        Log::info('Payment record created', ['payment_id' => $payment->id, 'order_id' => $orderId]);

        try {
            $snapToken = $this->generateSnapToken($user, $jumlah, $orderId);

            Log::info('Snap token generated', ['order_id' => $orderId]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'amount' => $jumlah
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'order_id' => $orderId,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Hapus payment yang gagal
            Payment::where('order_id', $orderId)->delete();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Generate Snap Token
     */
    private function generateSnapToken($user, $amount, $orderId)
    {
        if (empty($orderId)) {
            throw new \Exception('Order ID tidak boleh kosong');
        }
        
        if ($amount <= 0) {
            throw new \Exception('Jumlah pembayaran tidak valid');
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'item_details' => [
                [
                    'id'       => 'PD-' . date('Y'),
                    'price'    => (int) $amount,
                    'quantity' => 1,
                    'name'     => 'Biaya Pendaftaran PMB ' . date('Y'),
                ]
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap ?? $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '081234567890',
            ],
            'enabled_payments' => [
                'gopay', 'shopeepay', 'qris', 'bank_transfer', 
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        Log::info('Generate Snap Token Params', [
            'order_id' => $orderId,
            'amount' => $amount
        ]);

        return Snap::getSnapToken($params);
    }

    /**
     * Webhook dari Midtrans
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('📥 MIDTRANS WEBHOOK RECEIVED', [
                'payload' => $request->all(),
                'ip' => $request->ip()
            ]);

            // Validasi signature key
            $serverKey = config('midtrans.server_key');
            $orderId = $request->order_id;
            $statusCode = $request->status_code;
            $grossAmount = $request->gross_amount;
            
            $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            
            if (!hash_equals($signature, $request->signature_key ?? '')) {
                Log::error('❌ INVALID SIGNATURE', ['order_id' => $orderId]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Cari payment
            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                Log::error('❌ PAYMENT NOT FOUND', ['order_id' => $orderId]);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $transactionStatus = $request->transaction_status;
            $paymentType = $request->payment_type;
            $fraudStatus = $request->fraud_status ?? '';

            Log::info('🔄 PROCESSING TRANSACTION', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'type' => $paymentType,
                'fraud' => $fraudStatus,
                'tipe_pembayaran' => $payment->tipe_pembayaran
            ]);

            // Update berdasarkan status
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $payment->update([
                            'status_transaksi' => 'challenge',
                            'payload' => json_encode($request->all()),
                        ]);
                    } else if ($fraudStatus == 'accept') {
                        $this->updatePaymentSuccess($payment, $request);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $this->updatePaymentSuccess($payment, $request);
            } else if ($transactionStatus == 'pending') {
                $payment->update([
                    'status_transaksi' => 'pending',
                    'payload' => json_encode($request->all()),
                ]);
            } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $payment->update([
                    'status_transaksi' => $transactionStatus,
                    'payload' => json_encode($request->all()),
                ]);
            }

            Log::info('✅ WEBHOOK PROCESSED SUCCESSFULLY', [
                'order_id' => $orderId,
                'new_status' => $payment->fresh()->status_transaksi
            ]);

            return response()->json(['message' => 'Notification processed'], 200);

        } catch (\Exception $e) {
            Log::error('🔥 WEBHOOK ERROR: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error processing webhook'], 500);
        }
    }

    /**
     * Update payment menjadi sukses dan update status user
     */
    private function updatePaymentSuccess($payment, $request)
    {
        $payment->update([
            'status_transaksi' => 'settlement',
            'id_transaksi'     => $request->transaction_id ?? null,
            'payload'          => json_encode($request->all()),
        ]);

        $user = User::find($payment->user_id);

        if ($user) {
            // Update berdasarkan tipe pembayaran
            if ($payment->tipe_pembayaran === 'pendaftaran' && !$user->is_bayar_pendaftaran) {
                $user->is_bayar_pendaftaran = true;
                $user->save();

                Log::info('✅ User payment status updated (pendaftaran)', [
                    'user_id' => $user->id,
                    'order_id' => $payment->order_id
                ]);

                $this->sendPaymentSuccessNotification($user->id, $payment, 'pendaftaran');
            } 
            elseif ($payment->tipe_pembayaran === 'ukt' && !$user->is_ukt_paid) {
                // ✨ PERBAIKAN: Panggil BayarUktController untuk generate NIM
                Log::info('🎯 Calling processSettlement for UKT payment', [
                    'user_id' => $user->id,
                    'order_id' => $payment->order_id
                ]);
                
                $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                $success = $bayarUktController->processSettlement($payment);
                
                if ($success) {
                    Log::info('✅ UKT settlement processed with NIM generation', [
                        'user_id' => $user->id,
                        'nim' => $user->fresh()->nim
                    ]);
                } else {
                    Log::error('❌ Failed to process UKT settlement', [
                        'user_id' => $user->id
                    ]);
                    
                    // Fallback: Update status saja tanpa NIM
                    $user->is_ukt_paid = true;
                    $user->save();
                }

                $this->sendPaymentSuccessNotification($user->id, $payment, 'ukt');
            }
        }
    }

    /**
     * Kirim notifikasi pembayaran sukses
     */
    private function sendPaymentSuccessNotification($userId, $payment, $type = 'pendaftaran')
    {
        try {
            if (class_exists(\App\Models\Notif::class)) {
                $title = $type === 'ukt' ? 'Pembayaran UKT Berhasil!' : 'Pembayaran Pendaftaran Berhasil!';
                $message = $type === 'ukt' 
                    ? 'Pembayaran UKT sebesar Rp ' . number_format($payment->jumlah, 0, ',', '.') . ' telah berhasil diverifikasi.'
                    : 'Pembayaran pendaftaran sebesar Rp ' . number_format($payment->jumlah, 0, ',', '.') . ' telah berhasil diverifikasi.';
                
                Notif::create([
                    'user_id' => $userId,
                    'title' => $title,
                    'message' => $message,
                    'is_read' => false
                ]);
                
                Log::info('Notifikasi pembayaran sukses dikirim', ['user_id' => $userId, 'type' => $type]);
            }
        } catch (\Exception $e) {
            Log::error('Gagal membuat notifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Halaman finish setelah pembayaran
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        Log::info('Payment finish page accessed', [
            'order_id' => $orderId,
            'status' => $transactionStatus
        ]);

        $payment = null;
        if ($orderId) {
            $payment = Payment::where('order_id', $orderId)->first();
            
            if ($payment) {
                // PENTING: Update status berdasarkan transaction_status dari Midtrans redirect
                if (in_array($transactionStatus, ['settlement', 'capture'])) {
                    // Update payment status jika belum settlement
                    if ($payment->status_transaksi !== 'settlement') {
                        $payment->status_transaksi = 'settlement';
                        $payment->save();
                        
                        Log::info('Payment status updated to settlement', ['order_id' => $orderId]);
                    }
                    
                    // Update user status
                    $user = User::find($payment->user_id);
                    if ($user) {
                        if ($payment->tipe_pembayaran === 'pendaftaran' && !$user->is_bayar_pendaftaran) {
                            $user->is_bayar_pendaftaran = true;
                            $user->save();
                            Log::info('User is_bayar_pendaftaran updated to TRUE', ['user_id' => $user->id]);
                        } 
                        elseif ($payment->tipe_pembayaran === 'ukt' && !$user->is_ukt_paid) {
                            // ✨ PERBAIKAN: Generate NIM saat finish juga
                            Log::info('🎯 Processing UKT settlement at finish page', [
                                'user_id' => $user->id,
                                'order_id' => $orderId
                            ]);
                            
                            $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                            $success = $bayarUktController->processSettlement($payment);
                            
                            if (!$success) {
                                // Fallback
                                $user->is_ukt_paid = true;
                                $user->save();
                            }
                            
                            Log::info('User is_ukt_paid updated to TRUE', [
                                'user_id' => $user->id,
                                'nim' => $user->fresh()->nim
                            ]);
                        }
                    }
                }
            }
        }

        return view('bayar.finish', compact('payment', 'transactionStatus'));
    }

    /**
     * Upload bukti transfer manual
     */
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jumlah' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->is_bayar_pendaftaran) {
            return back()->with('info', 'Anda sudah menyelesaikan pembayaran.');
        }

        $path = $request->file('bukti_bayar')->store('bukti-pembayaran', 'public');

        Payment::create([
            'user_id'          => $user->id,
            'order_id'         => 'MANUAL-PD-' . $user->id . '-' . time(),
            'jumlah'           => $request->jumlah,
            'tipe_pembayaran'  => 'pendaftaran',
            'status_transaksi' => 'manual-upload',
            'bukti_manual'     => $path,
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Polling status pembayaran
     */
    public function pollStatus(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if (!$orderId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order ID required'
            ], 400);
        }

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Payment not found'
            ], 404);
        }

        // Jika status sudah settlement, pastikan user terupdate
        if ($payment->status_transaksi === 'settlement') {
            $user = User::find($payment->user_id);
            if ($user) {
                if ($payment->tipe_pembayaran === 'pendaftaran' && !$user->is_bayar_pendaftaran) {
                    $user->is_bayar_pendaftaran = true;
                    $user->save();
                    $this->sendPaymentSuccessNotification($user->id, $payment, 'pendaftaran');
                } elseif ($payment->tipe_pembayaran === 'ukt' && !$user->is_ukt_paid) {
                    // ✨ PERBAIKAN: Generate NIM saat polling juga
                    $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                    $bayarUktController->processSettlement($payment);
                    $this->sendPaymentSuccessNotification($user->id, $payment, 'ukt');
                }
            }
        }

        return response()->json([
            'status' => $payment->status_transaksi,
            'is_bayar_pendaftaran' => $payment->user->is_bayar_pendaftaran ?? false,
            'is_ukt_paid' => $payment->user->is_ukt_paid ?? false,
            'nim' => $payment->user->nim ?? null,
            'tipe_pembayaran' => $payment->tipe_pembayaran
        ]);
    }

    /**
     * Check status pembayaran
     */
    public function checkStatus(Request $request)
    {
        $orderId = $request->query('order_id');
        
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => 'not_found'
            ], 404);
        }

        // ✨ PERBAIKAN: Generate NIM jika UKT settlement
        if ($payment->tipe_pembayaran === 'ukt' && 
            $payment->status_transaksi === 'settlement') {
            $user = $payment->user;
            if ($user && !$user->is_ukt_paid) {
                $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                $bayarUktController->processSettlement($payment);
            }
        }

        return response()->json([
            'status' => $payment->status_transaksi,
            'is_bayar_pendaftaran' => $payment->user->is_bayar_pendaftaran ?? false,
            'is_ukt_paid' => $payment->user->is_ukt_paid ?? false,
            'nim' => $payment->user->nim ?? null
        ]);
    }
}