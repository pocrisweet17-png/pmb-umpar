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

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->is_bayar_pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan pembayaran pendaftaran.'
            ], 400);
        }

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
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
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran Anda sudah diverifikasi.'
            ], 400);
        }

        // Cek payment yang masih pending dan belum expire (< 24 jam)
        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'pendaftaran')
            ->where('status_transaksi', 'pending')
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if ($pendingPayment) {
            // Gunakan payment yang masih pending
            $orderId = $pendingPayment->order_id;
        } else {
            // Buat order_id baru untuk payment baru atau retry
            $orderId = 'PMB-PD-' . $user->id . '-' . time();
            
            Payment::create([
                'user_id'          => $user->id,
                'order_id'         => $orderId,
                'jumlah'           => $jumlah,
                'tipe_pembayaran'  => 'pendaftaran',
                'status_transaksi' => 'pending',
            ]);
        }

        try {
            $snapToken = $this->generateSnapToken($user, $jumlah, $orderId);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'order_id' => $orderId,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Jika error karena duplicate order_id, buat order_id baru
            if (strpos($e->getMessage(), 'order_id') !== false || 
                strpos($e->getMessage(), 'already exists') !== false) {
                
                // Hapus payment yang baru dibuat jika bukan pending payment lama
                if (!$pendingPayment) {
                    Payment::where('order_id', $orderId)->delete();
                }
                
                // Generate order_id baru dengan random string
                $newOrderId = 'PMB-PD-' . $user->id . '-' . time() . '-' . substr(md5(uniqid()), 0, 6);
                
                Payment::create([
                    'user_id'          => $user->id,
                    'order_id'         => $newOrderId,
                    'jumlah'           => $jumlah,
                    'tipe_pembayaran'  => 'pendaftaran',
                    'status_transaksi' => 'pending',
                ]);
                
                try {
                    $snapToken = $this->generateSnapToken($user, $jumlah, $newOrderId);
                    
                    return response()->json([
                        'success' => true,
                        'snap_token' => $snapToken,
                        'order_id' => $newOrderId
                    ]);
                } catch (\Exception $e2) {
                    Log::error('Midtrans Retry Error: ' . $e2->getMessage());
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateSnapToken($user, $amount, $orderId)
    {
            // Validasi input
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
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '081234567890',
            ],
            'enabled_payments' => [
                'gopay', 'shopeepay', 'qris', 'bank_transfer', 'echannel',
                'bca_klikpay', 'bca_klikbca', 'bri_epay', 'cimb_clicks', 'credit_card',
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];
        Log::info('Generate Snap Token Params', [
            'order_id' => $orderId,
            'amount' => $amount,
            'params' => $params
        ]);

        return Snap::getSnapToken($params);
    }

    public function webhook(Request $request)
{
    try {
        // Log semua data masuk untuk debugging
        Log::info('📥 MIDTRANS WEBHOOK RECEIVED', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
            'ip' => $request->ip(),
            'url' => $request->fullUrl()
        ]);

        // Validasi signature key
        $serverKey = config('midtrans.server_key');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        
        // Generate signature
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        Log::info('🔑 SIGNATURE VERIFICATION', [
            'generated' => $signature,
            'received' => $request->signature_key,
            'match' => hash_equals($signature, $request->signature_key)
        ]);

        if (!hash_equals($signature, $request->signature_key)) {
            Log::error('❌ INVALID SIGNATURE', [
                'order_id' => $orderId
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Proses notifikasi
        $notif = new Notification();
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status ?? '';

        Log::info('🔄 PROCESSING TRANSACTION', [
            'order_id' => $orderId,
            'status' => $transaction,
            'type' => $type,
            'fraud' => $fraud
        ]);

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::error('❌ PAYMENT NOT FOUND', ['order_id' => $orderId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update berdasarkan status
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->status_transaksi = 'challenge';
                } else if ($fraud == 'accept') {
                    $this->updatePaymentSuccess($payment, $notif);
                }
            }
        } else if ($transaction == 'settlement') {
            $this->updatePaymentSuccess($payment, $notif);
        } else if ($transaction == 'pending') {
            $payment->update([
                'status_transaksi' => 'pending',
                'payload' => json_encode($notif->getResponse()),
            ]);
        } else if ($transaction == 'deny') {
            $payment->update([
                'status_transaksi' => 'deny',
                'payload' => json_encode($notif->getResponse()),
            ]);
        } else if ($transaction == 'expire') {
            $payment->update([
                'status_transaksi' => 'expire',
                'payload' => json_encode($notif->getResponse()),
            ]);
        } else if ($transaction == 'cancel') {
            $payment->update([
                'status_transaksi' => 'cancel',
                'payload' => json_encode($notif->getResponse()),
            ]);
        }

        Log::info('✅ WEBHOOK PROCESSED SUCCESSFULLY', [
            'order_id' => $orderId,
            'new_status' => $payment->status_transaksi,
            'user_updated' => $payment->user->is_bayar_pendaftaran ?? false
        ]);

        return response()->json(['message' => 'Notification processed'], 200);

    } catch (\Exception $e) {
        Log::error('🔥 WEBHOOK ERROR: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        return response()->json(['message' => 'Error processing webhook'], 500);
    }
}

    private function updatePaymentSuccess($payment, $notif)
    {
        $payment->update([
            'status_transaksi' => 'settlement',
            'id_transaksi'     => $notif->transaction_id,
            'payload'          => json_encode($notif->getResponse()),
        ]);

        $user = User::find($payment->user_id);

        if ($user && !$user->is_bayar_pendaftaran) {
            $user->is_bayar_pendaftaran = true;
            $user->save();

                    Log::info('User payment status updated via webhook', [
            'user_id' => $user->id,
            'order_id' => $payment->order_id,
            'status' => 'settlement'
        ]);
             $this->sendPaymentSuccessNotification($user->id, $payment);
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        $payment = $orderId
            ? Payment::where('order_id', $orderId)->first()
            : null;

        return view('bayar.finish', compact('payment', 'transactionStatus'));
    }

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
            'order_id'         => 'MANUAL-' . $user->id . '-' . time(),
            'jumlah'           => $request->jumlah,
            'tipe_pembayaran'  => 'pendaftaran',
            'status_transaksi' => 'manual-upload',
            'bukti_manual'     => $path,
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    public function callback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transaction == 'capture' || $transaction == 'settlement') {
            $payment->status_transaksi = 'settlement';

            $user = $payment->user;
            if ($user) {
                $user->is_bayar_pendaftaran = true;
                $user->save();
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

        return response()->json(['message' => 'Callback processed']);
    }
    private function sendPaymentSuccessNotification($userId, $payment)
{
    try {
        Notif::create([
            'user_id' => $userId,
            'title' => 'Pembayaran Berhasil!',
            'message' => 'Pembayaran pendaftaran sebesar Rp ' . number_format($payment->jumlah, 0, ',', '.') . ' telah berhasil diverifikasi.',
            'is_read' => false
        ]);
        
        Log::info('Notifikasi pembayaran sukses dikirim untuk user_id: ' . $userId);
    } catch (\Exception $e) {
        Log::error('Gagal membuat notifikasi: ' . $e->getMessage());
    }
}
// Tambahkan method ini di PaymentController.php
public function pollStatus(Request $request)
{
    $request->validate([
        'order_id' => 'required|string'
    ]);

    $payment = Payment::where('order_id', $request->order_id)->first();

    if (!$payment) {
        return response()->json([
            'status' => 'not_found',
            'message' => 'Payment not found'
        ], 404);
    }

    // Jika status sudah settlement, update user
    if ($payment->status_transaksi === 'settlement') {
        $user = User::find($payment->user_id);
        if ($user && !$user->is_bayar_pendaftaran) {
            $user->is_bayar_pendaftaran = true;
            $user->save();
            
            // Kirim notifikasi
            $this->sendPaymentSuccessNotification($user->id, $payment);
        }
    }

    return response()->json([
        'status' => $payment->status_transaksi,
        'user_status' => $payment->user->is_bayar_pendaftaran ?? false
    ]);
}

public function checkStatus(Request $request)
{
    $payment = Payment::where('order_id', $request->order_id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$payment) {
        return response()->json([
            'status' => 'not_found'
        ], 404);
    }

    return response()->json([
        'status' => $payment->status_transaksi,
        'is_bayar_pendaftaran' => $payment->user->is_bayar_pendaftaran ?? false
    ]);
}
}
