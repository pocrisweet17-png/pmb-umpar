<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $notif = new Notification();

        $orderId = $notif->order_id;

        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $payment->update([
            'status_transaksi'  => $notif->transaction_status,
            'tipe_pembayaran'   => $notif->payment_type,
            'id_transaksi'      => $notif->transaction_id,
            'status_penipuan'   => $notif->fraud_status ?? null,
            'payload'           => json_encode($notif) //json
        ]);

        return response()->json(['success' => true]);
    }
}