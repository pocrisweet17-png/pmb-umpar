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

   
    public function tagihan()
    {
       $reg = request()->user();
        // Mengambil biaya berdasarkan prodi yang dipilih
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $reg->prodi_1)
            ->firstOrFail();

        return view('payment.tagihan', compact('reg', 'biaya'));
    }

   
    public function bayar($tipe)
    {
        $reg = request()->user();

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $reg->prodi_1)
            ->firstOrFail();

        // Cek apakah sudah lunas
        $sudahLunas = Payment::where('id_registrasi', $reg->idRegistrasi)
            ->where('tipe_pembayaran', $tipe)
            ->where('status_transaksi', 'settlement')
            ->exists();

        if ($sudahLunas) {
            return redirect()->back()->with('error', 'Pembayaran sudah lunas.');
        }

        $jumlah = $biaya->biaya_pendaftaran;
        $nama = "Biaya Pendaftaran";

        $order_id = "PD-" . $reg->idRegistrasi . "-" . time();

        $payment = Payment::create([
            'id_registrasi' => $reg->idRegistrasi,
            'order_id' => $order_id,
            'jumlah' => $jumlah,
            'tipe_pembayaran' => $tipe,
            'status_transaksi' => 'pending',
        ]);

        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $jumlah,
        ];

        $item_details = [[
            'id' => $tipe,
            'price' => $jumlah,
            'quantity' => 1,
            'name' => $nama . " - " . $reg->namaLengkap,
        ]];

        $customer_details = [
            'first_name' => $reg->namaLengkap,
            'email' => $reg->email,
            'phone' => $reg->noHp,
        ];

        $snapToken = Snap::getSnapToken([
            'transaction_details' => $transaction_details,
            'item_details'        => $item_details,
            'customer_details'    => $customer_details
        ]);

        return view('payment.checkout', compact('snapToken', 'payment', 'reg'));
    }

   //midrans webhok
    public function webhook()
    {
        $notif = new \Midtrans\Notification();

        $payment = Payment::where('order_id', $notif->order_id)->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($notif->transaction_status == 'settlement') {

            $payment->update([
                'status_transaksi' => 'settlement',
                'id_transaksi' => $notif->transaction_id,
                'payload' => json_encode($notif),
            ]);

            // UPDATE STATUS USER JADI PAID
            $payment->registrasi->update([
                'is_paid' => 1
            ]);
        } 
        else if (in_array($notif->transaction_status, ['expire', 'cancel', 'deny'])) {
            $payment->update(['status_transaksi' => 'expire']);
        }

        return response('OK', 200);
    }

    // redirec klo udah bayar
    public function selesai()
    {
        return redirect()->route('tagihan')
            ->with('success', 'Pembayaran sedang diproses...');
    }
}
