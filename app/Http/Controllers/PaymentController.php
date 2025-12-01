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
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Halaman tagihan calon mahasiswa
    public function tagihan($idRegistrasi)
    {
        $reg = Registrasi::with('payments')->findOrFail($idRegistrasi);

        $biaya = BiayaPmb::where('tahun', $reg->gelombang ?? date('Y'))
                         ->where('kodeProdi', $reg->kodeProdi)
                         ->firstOrFail();

        return view('payment.tagihan', compact('reg', 'biaya'));
    }

    public function bayar($idRegistrasi, $tipe)
    {
        $reg = Registrasi::findOrFail($idRegistrasi);
        $biaya = BiayaPmb::where('tahun', $reg->gelombang ?? date('Y'))
                         ->where('kodeProdi', $reg->kodeProdi)
                         ->firstOrFail();

        $sudahLunas = Payment::where('id_registrasi', $idRegistrasi)
            ->where('tipe_pembayaran', $tipe)
            ->where('status_transaksi', 'settlement')
            ->exists();

        if ($sudahLunas) {
            return redirect()->back()->with('error', 'Sudah lunas!');
        }

        $jumlah = $tipe === 'pendaftaran' ? $biaya->biaya_pendaftaran : $biaya->ukt_semester_1;
        $nama = $tipe === 'pendaftaran' ? 'Biaya Pendaftaran' : 'UKT Semester 1';

        $order_id = strtoupper($tipe[0]) . "-{$reg->idRegistrasi}-" . time();

        $payment = Payment::create([
            'id_registrasi' => $idRegistrasi,
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
            'name' => $nama . " - " . $reg->nama_lengkap,
        ]];

        $customer_details = [
            'first_name' => $reg->nama_lengkap,
            'email' => $reg->email,
            'phone' => $reg->no_hp,
        ];

        $snapToken = Snap::getSnapToken(compact('transaction_details', 'item_details', 'customer_details'));

        return view('payment.checkout', compact('snapToken', 'payment', 'reg'));
    }

    // Webhook Midtrans (WAJIB HTTPS di production)
    public function webhook()
    {
        $notif = new \Midtrans\Notification();

        $payment = Payment::where('order_id', $notif->order_id)->firstOrFail();

        if ($notif->transaction_status == 'settlement') {
            $payment->update([
                'status_transaksi' => 'settlement',
                'id_transaksi' => $notif->transaction_id,
                'payload' => json_encode($notif),
            ]);
        } elseif (in_array($notif->transaction_status, ['expire', 'cancel', 'deny'])) {
            $payment->update(['status_transaksi' => 'expire']);
        }

        return response('OK', 200);
    }

    // Redirect setelah bayar
    public function selesai($idRegistrasi)
    {
        return redirect("/tagihan/{$idRegistrasi}")->with('success', 'Pembayaran sedang diproses!');
    }
}