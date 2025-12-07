<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Payment;
use App\Models\BiayaPmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    // ============================
    // 1. HALAMAN TAGIHAN
    // ============================
    public function index()
    {
        $user = request()->user();

        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->firstOrFail();

        return view('mahasiswa.bayar-pendaftaran', [
            'user' => $user,
            'reg' => $reg,
            'biaya_pendaftaran' => $biaya->biaya_pendaftaran
        ]);
    }


    // ======================================
    // 2. BAYAR VIA MIDTRANS (AUTO)
    // ======================================
    public function store()
    {
        $user = request()->user();
        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->firstOrFail();

        $jumlah = $biaya->biaya_pendaftaran;

        // Invoice Number
        $invoice = "INV-PD-" . $reg->id . "-" . time();

        $payment = Payment::create([
            'id_registrasi'   => $reg->id,
            'order_id'        => $invoice,
            'jumlah'          => $jumlah,
            'tipe_pembayaran' => 'pendaftaran',
            'status_transaksi'=> 'pending'
        ]);

        // MIDTRANS SNAP
        $payload = [
            'transaction_details' => [
                'order_id' => $invoice,
                'gross_amount' => $jumlah,
            ],
            'item_details' => [
                [
                    'id' => "PD",
                    'price' => $jumlah,
                    'quantity' => 1,
                    'name' => "Biaya Pendaftaran - " . $user->nama_lengkap,
                ]
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp,
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);

        return view('payment.checkout', [
            'snapToken' => $snapToken,
            'payment'   => $payment,
            'user'      => $user
        ]);
    }


    // ======================================
    // 3. QRIS MANUAL (UPLOAD BUKTI)
    // ======================================
    public function qris()
    {
        $user = request()->user();
        
        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->pilihan_1)
            ->firstOrFail();

        return view('payment.qris', [
            'user' => $user,
            'reg' => $reg,
            'jumlah' => $biaya->biaya_pendaftaran
        ]);
    }


    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $user = request()->user();
        $reg = Registrasi::where('user_id', $user->id)->firstOrFail();

        $filename = "bukti-{$reg->id}-" . time() . "." . $request->file('bukti_bayar')->extension();

        $path = $request->file('bukti_bayar')->storeAs('bukti-pembayaran', $filename, 'public');

        Payment::create([
            'id_registrasi'   => $reg->id,
            'order_id'        => "INV-MAN-" . time(),
            'jumlah'          => $request->jumlah,
            'tipe_pembayaran' => 'pendaftaran',
            'status_transaksi'=> 'manual-upload',
            'bukti_manual'    => $path,
        ]);

        // Auto Update Step
        $reg->update([
            'is_bayar_pendaftaran' => true,
        ]);

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload! Pembayaran sedang diverifikasi.');
    }


    // ======================================
    // 4. WEBHOOK MIDTRANS
    // ======================================
    public function webhook()
    {
        $notif = new \Midtrans\Notification();
        $payment = Payment::where('order_id', $notif->order_id)->first();

        if (! $payment) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        if ($notif->transaction_status == 'settlement') {

            $payment->update([
                'status_transaksi' => 'settlement',
                'id_transaksi'     => $notif->transaction_id,
                'payload'          => json_encode($notif),
            ]);

            // Auto update registrasi step
            $payment->registrasi->update([
                'is_bayar_pendaftaran' => true,
            ]);

        } else if (in_array($notif->transaction_status, ['deny', 'expire', 'cancel'])) {

            $payment->update([
                'status_transaksi' => 'expire',
            ]);
        }

        return response('OK', 200);
    }
}
