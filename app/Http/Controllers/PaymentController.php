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
        Config::$isProduction = config('midtrans.is_production', true);
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

        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'pendaftaran')
            ->where('status_transaksi', 'pending')
            ->whereNotNull('snap_token')
            ->where('snap_token_expires_at', '>', now())
            ->first();

        return view('bayar.index', compact('user', 'biaya_pendaftaran', 'pendingPayment'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'metode_pembayaran' => 'nullable|string|in:qris,gopay,shopeepay,dana,bank_transfer,alfamart,all',
        ]);

        $user = Auth::user();

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

        $jumlah = (int) $biaya->biaya_pendaftaran;

        $settledPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'pendaftaran')
            ->where('status_transaksi', 'settlement')
            ->first();

        if ($settledPayment) {
            if (!$user->is_bayar_pendaftaran) {
                $user->is_bayar_pendaftaran = true;
                $user->save();
            }

            return response()->json([
                'success' => false,
                'sudah_bayar' => true,
                'message' => 'Anda sudah pernah bayar.'
            ], 400);
        }

        // Hitung biaya admin & total
        $metodeDipilih   = $request->input('metode_pembayaran', 'all');
        $enabledPayments = $this->getEnabledPayments($metodeDipilih);
        $biayaAdmin      = (int) $this->getBiayaAdmin($metodeDipilih, $jumlah);
        $totalBayar      = $jumlah + $biayaAdmin;

        try {
            return \DB::transaction(function () use ($user, $jumlah, $biayaAdmin, $totalBayar, $enabledPayments, $metodeDipilih) {

                // Cari payment pending dalam 24 jam terakhir
                $existingPayment = Payment::where('user_id', $user->id)
                    ->where('tipe_pembayaran', 'pendaftaran')
                    ->where('status_transaksi', 'pending')
                    ->where('created_at', '>', now()->subHours(24))
                    // ->where('created_at', '>', now()->subMinute(1))
                    ->lockForUpdate()
                    ->first();

                if ($existingPayment) {

                    $sameAmount = (int) $existingPayment->jumlah === $totalBayar;

                    if ($sameAmount
                        && $existingPayment->snap_token
                        && $existingPayment->snap_token_expires_at
                        && $existingPayment->snap_token_expires_at->isFuture()) {

                        Log::info('Reusing cached snap token', [
                            'order_id'   => $existingPayment->order_id,
                            'expires_at' => $existingPayment->snap_token_expires_at,
                        ]);

                        return response()->json([
                            'success'     => true,
                            'snap_token'  => $existingPayment->snap_token,
                            'order_id'    => $existingPayment->order_id,
                            'amount'      => $jumlah,
                            'biaya_admin' => $biayaAdmin,
                            'total'       => $totalBayar,
                            'existing'    => true,
                            'cached'      => true,
                            'snap_token_expires_at'=> $existingPayment->snap_token_expires_at?->timestamp * 1000,
                        ]);
                    }

                    $newOrderId = 'PMB-PD-' . $user->id . '-' . time() . '-' . substr(uniqid(), -4);

                    Log::info('Updating existing payment (method changed or token expired)', [
                        'old_order_id' => $existingPayment->order_id,
                        'new_order_id' => $newOrderId,
                        'old_jumlah'   => (int) $existingPayment->jumlah,
                        'new_jumlah'   => $totalBayar,
                        'metode_baru'  => $metodeDipilih,
                    ]);

                    // Update row sama: ganti order_id, jumlah, reset token
                    $existingPayment->update([
                        'order_id'              => $newOrderId,
                        'jumlah'                => $totalBayar,
                        'snap_token'            => null,
                        'snap_token_expires_at' => null,
                    ]);

                    try {
                        $snapToken = $this->generateSnapToken(
                            $user,
                            $jumlah,
                            $newOrderId,
                            $enabledPayments,
                            $biayaAdmin
                        );

                        $existingPayment->update([
                            'snap_token'            => $snapToken,
                            // 'snap_token_expires_at' => now()->addMinute(1),
                            'snap_token_expires_at' => now()->addHours(24),
                        ]);

                        return response()->json([
                            'success'     => true,
                            'snap_token'  => $snapToken,
                            'order_id'    => $newOrderId,
                            'amount'      => $jumlah,
                            'biaya_admin' => $biayaAdmin,
                            'total'       => $totalBayar,
                            'existing'    => true,
                            'snap_token_expires_at'=> $existingPayment->snap_token_expires_at?->timestamp * 1000,
                        ]);

                    } catch (\Exception $e) {
                        Log::error('Midtrans Snap Token Error (update existing): ' . $e->getMessage(), [
                            'user_id'  => $user->id,
                            'order_id' => $newOrderId,
                        ]);

                        throw $e; 
                    }
                }

                $orderId = 'PMB-PD-' . $user->id . '-' . time() . '-' . substr(uniqid(), -4);

                $payment = Payment::create([
                    'user_id'          => $user->id,
                    'order_id'         => $orderId,
                    'jumlah'           => $totalBayar,
                    'tipe_pembayaran'  => 'pendaftaran',
                    'status_transaksi' => 'pending',
                ]);

                try {
                    $snapToken = $this->generateSnapToken($user, $jumlah, $orderId, $enabledPayments, $biayaAdmin);

                    $payment->update([
                        'snap_token'            => $snapToken,
                        'snap_token_expires_at' => now()->addHours(24),
                        // 'snap_token_expires_at' => now()->addMinute(),
                    ]);

                    Log::info('Payment created with snap token cached', [
                        'order_id'    => $orderId,
                        'biaya_pokok' => $jumlah,
                        'biaya_admin' => $biayaAdmin,
                        'total'       => $totalBayar,
                        'metode'      => $metodeDipilih,
                    ]);

                    return response()->json([
                        'success'     => true,
                        'snap_token'  => $snapToken,
                        'order_id'    => $orderId,
                        'amount'      => $jumlah,
                        'biaya_admin' => $biayaAdmin,
                        'total'       => $totalBayar,
                        'snap_token_expires_at'=> $payment->snap_token_expires_at?->timestamp * 1000,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Midtrans Snap Token Error (new payment): ' . $e->getMessage(), [
                        'user_id'  => $user->id,
                        'order_id' => $orderId,
                    ]);

                    $payment->delete();
                    throw $e; // rollback transaction
                }
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    /**
     * Generate Snap Token
     */
    private function generateSnapToken($user, $amount, $orderId, $enabledPayments = null, $biayaAdmin = 0)
    {
        if (empty($orderId)) {
            throw new \Exception('Order ID tidak boleh kosong');
        }

        if ($amount <= 0) {
            throw new \Exception('Jumlah pembayaran tidak valid');
        }

        //  Hitung total
        $totalAmount = (int) $amount + (int) $biayaAdmin;

        //  Item details dengan biaya admin terpisah
        $itemDetails = [
            [
                'id'       => 'PMB-' . date('Y-m') . '-' . $user->id,
                'price'    => (int) $amount,
                'quantity' => 1,
                'name'     => 'Biaya Pendaftaran PMB ' . date('Y'),
            ]
        ];

        //  Tambahkan biaya admin jika ada
        if ($biayaAdmin > 0) {
            $itemDetails[] = [
                'id'       => 'ADMIN-FEE-' . $user->id,
                'price'    => (int) $biayaAdmin,
                'quantity' => 1,
                'name'     => 'Biaya Admin Pembayaran',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user->nama_lengkap ?? $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '-',
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
            'expiry' => [
            'start_time' => now()->format('Y-m-d H:i:s O'),
            'unit'       => 'hours',
            'duration'   => 24,
        ],
        ];

        // Tambahkan enabled_payments jika ada
        if ($enabledPayments && is_array($enabledPayments)) {
            $params['enabled_payments'] = $enabledPayments;
        }

        return Snap::getSnapToken($params);
    }

    /**
     * Webhook dari Midtrans
     */
    public function webhook(Request $request)
    {
        try {
            Log::info(' MIDTRANS WEBHOOK RECEIVED', [
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
                Log::error(' INVALID SIGNATURE', ['order_id' => $orderId]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Cari payment
            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                Log::error(' PAYMENT NOT FOUND', ['order_id' => $orderId]);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $transactionStatus = $request->transaction_status;
            $paymentType = $request->payment_type;
            $fraudStatus = $request->fraud_status ?? '';

            Log::info(' PROCESSING TRANSACTION', [
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

            Log::info(' WEBHOOK PROCESSED SUCCESSFULLY', [
                'order_id' => $orderId,
                'new_status' => $payment->fresh()->status_transaksi
            ]);

            return response()->json(['message' => 'Notification processed'], 200);

        } catch (\Exception $e) {
            Log::error(' WEBHOOK ERROR: ' . $e->getMessage(), [
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

                Log::info(' User payment status updated (pendaftaran)', [
                    'user_id' => $user->id,
                    'order_id' => $payment->order_id
                ]);

                $this->sendPaymentSuccessNotification($user->id, $payment, 'pendaftaran');
            } 
            elseif ($payment->tipe_pembayaran === 'ukt' && !$user->is_ukt_paid) {
                Log::info(' Calling processSettlement for UKT payment', [
                    'user_id' => $user->id,
                    'order_id' => $payment->order_id
                ]);
                
                $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                $success = $bayarUktController->processSettlement($payment);
                
                if ($success) {
                    Log::info('UKT settlement processed with NIM generation', [
                        'user_id' => $user->id,
                        'nim' => $user->fresh()->nim
                    ]);
                } else {
                    Log::error(' Failed to process UKT settlement', [
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
        'status_from_url' => $transactionStatus
    ]);

    $payment = null;
    if ($orderId) {
        $payment = Payment::where('order_id', $orderId)
            ->where('user_id', Auth::id()) // pastikan order milik user yang login
            ->first();

        // JANGAN trust query string. Verifikasi langsung ke Midtrans API
        if ($payment && in_array($transactionStatus, ['settlement', 'capture'])) {

            try {
                //  Verifikasi status dari Midtrans
                $midtransStatus = \Midtrans\Transaction::status($orderId);
                $realStatus = is_object($midtransStatus)
                    ? $midtransStatus->transaction_status
                    : ($midtransStatus['transaction_status'] ?? null);

                Log::info('Midtrans verified status', [
                    'order_id' => $orderId,
                    'real_status' => $realStatus
                ]);

                if (in_array($realStatus, ['settlement', 'capture'])) {

                    if ($payment->status_transaksi !== 'settlement') {
                        $payment->status_transaksi = 'settlement';
                        $payment->save();
                    }

                    $user = User::find($payment->user_id);
                    if ($user) {
                        if ($payment->tipe_pembayaran === 'pendaftaran' && !$user->is_bayar_pendaftaran) {
                            $user->is_bayar_pendaftaran = true;
                            $user->save();
                            $this->sendPaymentSuccessNotification($user->id, $payment, 'pendaftaran');
                        }
                        elseif ($payment->tipe_pembayaran === 'ukt' && !$user->is_ukt_paid) {
                            $bayarUktController = app(\App\Http\Controllers\BayarUktController::class);
                            $success = $bayarUktController->processSettlement($payment);

                            if (!$success) {
                                $user->is_ukt_paid = true;
                                $user->save();
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                Log::error('Failed to verify Midtrans status at finish', [
                    'order_id' => $orderId,
                    'error' => $e->getMessage()
                ]);
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

 
    // pembayaran offline
    // Di PaymentController.php
    public function storeOffline(Request $request)
    {
        Log::info('========== OFFLINE PAYMENT STARTED ==========');
        Log::info('Request data:', $request->all());
        Log::info('User ID:', [Auth::id()]);

        try {
            $user = Auth::user();

            if ($user->is_bayar_pendaftaran) {
                Log::warning('User already paid', ['user_id' => $user->id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah menyelesaikan pembayaran pendaftaran.'
                ], 400);
            }

            ///CEK PAYMENT OFFLINE YANG SUDAH ADA
            $existingOfflinePayment = Payment::where('user_id', $user->id)
                ->where('tipe_pembayaran', 'pendaftaran')
                ->where('metode_pembayaran', 'offline')
                ->whereIn('status_transaksi', ['pending-offline', 'pending'])
                ->first();

            if ($existingOfflinePayment) {
                Log::info('✅ Offline payment already exists, returning existing data', [
                    'user_id' => $user->id,
                    'order_id' => $existingOfflinePayment->order_id,
                    'status' => $existingOfflinePayment->status_transaksi
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran offline Anda sudah terdaftar. Silakan datang ke kampus.',
                    'order_id' => $existingOfflinePayment->order_id,
                    'existing' => true
                ], 200);
            }

            $biaya = BiayaPmb::where('tahun', date('Y'))
                ->where('kodeProdi', $user->pilihan_1)
                ->first();

            if (!$biaya) {
                Log::error('Biaya not found', [
                    'user_id' => $user->id,
                    'kodeProdi' => $user->pilihan_1
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Biaya pendaftaran tidak ditemukan.'
                ], 404);
            }

            $jumlah = $biaya->biaya_pendaftaran;
            $orderId = 'OFFLINE-PD-' . $user->id . '-' . time();

            // Create payment record
            $payment = Payment::create([
                'user_id'           => $user->id,
                'order_id'          => $orderId,
                'jumlah'            => $jumlah,
                'tipe_pembayaran'   => 'pendaftaran',
                'metode_pembayaran' => 'offline',
                'status_transaksi'  => 'pending-offline',
            ]);

            Log::info('✅ Offline payment created successfully', [
                'payment_id' => $payment->id,
                'user_id' => $user->id,
                'order_id' => $orderId,
                'jumlah' => $jumlah
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Silakan datang ke kampus untuk melakukan pembayaran.',
                'order_id' => $orderId,
                'payment_id' => $payment->id
            ], 200);

        } catch (\Exception $e) {
            Log::error('❌ Offline payment error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi offline: ' . $e->getMessage()
            ], 500);
        }
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
    // method untuk aktifkan satu satu payment, permintaan pak untung
    private function getEnabledPayments($metode)
    {
        $mapping = [
            'qris'          => ['other_qris'],
            // 'gopay'         => ['gopay'],
            // 'shopeepay'     => ['shopeepay'],
            // 'dana'          => ['dana'],
            'bank_transfer' => ['bri_va', 'bni_va', 'echannel'],
            // 'alfamart'      => ['alfamart'],   
            // 'all'           => ['gopay', 'shopeepay', 'other_qris', 'bank_transfer', 'bca_va', 'bni_va', 'bri_va'],
        ];

        return $mapping[$metode] ?? $mapping['all'];
    }
    // biaya admin atau biaya tamahan, perminataanya pak untung
    private function getBiayaAdmin($metode, $jumlah)
    {
        $biayaAdmin = [
            'qris'          => $jumlah * 0.007 * 1.12, // 0.7%
            'gopay'         => $jumlah * 0.02,  // 2%
            'shopeepay'     => $jumlah * 0.02,  // 2%
            'dana'          => $jumlah * 0.015, // 1.5% 
            'bank_transfer' => 4500,
            'alfamart'      => 5000,
            'all'           => 0,
        ];
    
        return $biayaAdmin[$metode] ?? 0;
    }
}