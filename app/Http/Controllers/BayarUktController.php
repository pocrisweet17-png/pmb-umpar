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
    }

    /**
     * Halaman pembayaran (dengan modal)
     */
    public function index()
    {
        $user = Auth::user();

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
            return back()->with('error', 'Biaya semester belum tersedia untuk program studi Anda.');
        }

        $biaya_ukt = $biaya->biaya_ukt;

        return view('bayar.index', compact('user', 'biaya_ukt'));
    }

    /**
     * Generate Snap Token (dipanggil via AJAX)
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi sudah bayar atau belum
        if ($user->is_ukt_paid) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menyelesaikan pembayaran ini.'
            ], 400);
        }

        // Ambil biaya
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
            ->first();

        if (!$biaya) {
            return response()->json([
                'success' => false,
                'message' => 'Biaya semester tidak ditemukan.'
            ], 404);
        }

        $jumlah = $biaya->biaya_ukt;

        // Cek apakah ada payment pending/settlement
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('tipe_pembayaran', 'ukt')
            ->whereIn('status_transaksi', ['pending', 'settlement'])
            ->first();

        if ($existingPayment && $existingPayment->status_transaksi === 'settlement') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran Anda sudah diverifikasi.'
            ], 400);
        }

        // Jika ada pending, gunakan order_id yang sama
        if ($existingPayment) {
            $orderId = $existingPayment->order_id;
        } else {
            // Generate order_id baru
            $orderId = 'PMB-PD-' . $user->id . '-' . time();
            
            // Buat payment record
            Payment::create([
                'user_id'          => $user->id,
                'order_id'         => $orderId,
                'jumlah'           => $jumlah,
                'tipe_pembayaran'  => 'ukt',
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
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi pembayaran. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Generate Snap Token
     */
    private function generateSnapToken($user, $amount, $orderId)
    {
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
                    'name'     => 'Biaya ukt ' . date('Y'),
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
                'finish' => route('payment.finish'),
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Webhook dari Midtrans
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Midtrans Webhook Received', [
                'order_id' => $request->order_id,
                'transaction_status' => $request->transaction_status,
                'all_data' => $request->all()
            ]);

            $serverKey = config('midtrans.server_key');
            $hashed = hash('sha512', 
                $request->order_id . 
                $request->status_code . 
                $request->gross_amount . 
                $serverKey
            );

            if ($hashed !== $request->signature_key) {
                Log::error('Invalid Midtrans Signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $notif = new Notification();
            $payment = Payment::where('order_id', $notif->order_id)->first();

            if (!$payment) {
                Log::error('Payment not found: ' . $notif->order_id);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status ?? '';

            Log::info('Processing payment', [
                'order_id' => $notif->order_id,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus
            ]);

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->updatePaymentSuccess($payment, $notif);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->updatePaymentSuccess($payment, $notif);
            } elseif ($transactionStatus == 'pending') {
                $payment->update([
                    'status_transaksi' => 'pending',
                    'payload' => json_encode($notif->getResponse()),
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $payment->update([
                    'status_transaksi' => $transactionStatus,
                    'payload' => json_encode($notif->getResponse()),
                ]);
            }

            return response()->json(['message' => 'Notification processed'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing webhook'], 500);
        }
    }

    /**
     * Update payment menjadi success
     */
    private function updatePaymentSuccess($payment, $notif)
    {
        $payment->update([
            'status_transaksi' => 'settlement',
            'id_transaksi'     => $notif->transaction_id,
            'payload'          => json_encode($notif->getResponse()),
        ]);

        $user = User::find($payment->user_id);
        if ($user && !$user->is_ukt_paid) {
            $user->is_ukt_paid = true;
            $user->save();

            Log::info('User payment status updated', [
                'user_id' => $user->id,
                'order_id' => $payment->order_id
            ]);
        }
    }

    /**
     * Halaman finish setelah pembayaran
     */
    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        $payment = null;
        if ($orderId) {
            $payment = Payment::where('order_id', $orderId)->first();
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

        if ($user->is_ukt_paid) {
            return back()->with('info', 'Anda sudah menyelesaikan pembayaran.');
        }

        $path = $request->file('bukti_bayar')->store('bukti-pembayaran', 'public');

        Payment::create([
            'user_id'          => $user->id,
            'order_id'         => 'MANUAL-' . $user->id . '-' . time(),
            'jumlah'           => $request->jumlah,
            'tipe_pembayaran'  => 'ukt',
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

        // UPDATE TABLE USERS JIKA SETTLEMENT
        $user = $payment->user;
        if ($user) {
            $user->is_ukt_paid = true;
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

}