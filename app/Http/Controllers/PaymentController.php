<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Payment;
use App\Models\BiayaPmb;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey       = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction    = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized     = true;
        Config::$is3ds           = true;
    }

    //  HALAMAN TAGIHAN
    public function tagihan()
    {
        $user = request()->user();

        // Ambil registrasi user
        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        // Biaya berdasarkan pilihan prodi pertama
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->firstOrFail();

        return view('payment.tagihan', compact('reg', 'biaya', 'user'));
    }

    // BAYAR TAGIHAN

    public function bayar($tipe)
    {
        $user = request()->user();
        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->firstOrFail();

        // Cek apakah sudah bayar
        $sudahLunas = Payment::where('id_registrasi', $reg->id)
            ->where('tipe_pembayaran', $tipe)
            ->where('status_transaksi', 'settlement')
            ->exists();

        if ($sudahLunas) {
            return redirect()->back()->with('error', 'Pembayaran sudah lunas.');
        }

        $jumlah = $biaya->biaya_pendaftaran;
        $nama = "Biaya Pendaftaran";

        $order_id = "PD-" . $reg->id . "-" . time();

        // Catat transaksi
        $payment = Payment::create([
            'id_registrasi' => $reg->id,
            'order_id' => $order_id,
            'jumlah' => $jumlah,
            'tipe_pembayaran' => $tipe,
            'status_transaksi' => 'pending',
        ]);

        // Midtrans payload
        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $jumlah,
        ];

        $item_details = [[
            'id' => $tipe,
            'price' => $jumlah,
            'quantity' => 1,
            'name' => $nama . " - " . $user->nama_lengkap,
        ]];

        $customer_details = [
            'first_name' => $user->nama_lengkap,
            'email'      => $user->email,
            'phone'      => $user->no_whatsapp,
        ];

        $snapToken = Snap::getSnapToken([
            'transaction_details' => $transaction_details,
            'item_details'        => $item_details,
            'customer_details'    => $customer_details
        ]);

        return view('payment.checkout', compact('snapToken', 'payment', 'user', 'reg'));
    }

    // WEBHOOK UNTUK MIDTRANS
    public function webhook()
    {
        $notif = new \Midtrans\Notification();

        $payment = Payment::where('order_id', $notif->order_id)->first();

        if (! $payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($notif->transaction_status == 'settlement') {

            $payment->update([
                'status_transaksi' => 'settlement',
                'id_transaksi'     => $notif->transaction_id,
                'payload'          => json_encode($notif),
            ]);

            // UPDATE REGISTRASI STEP 2 → Sudah Bayar
            $payment->registrasi->update([
                'is_bayar_pendaftaran' => true,
            ]);

        } elseif (in_array($notif->transaction_status, ['expire', 'cancel', 'deny'])) {

            $payment->update([
                'status_transaksi' => 'expire',
            ]);
        }

        return response('OK', 200);
    }


    //  REDIRECT SETELAH BAYAR
    public function selesai()
    {
        return redirect()->route('tagihan')
            ->with('success', 'Pembayaran sedang diproses...');
    }
}
