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
    // 1. HALAMAN PEMBAYARAN PENDAFTARAN
    // ============================
    public function index()
    {
        $user = request()->user();

        // Cek apakah user sudah memilih prodi
        if (!$user->is_prodi_selected || !$user->kodeProdi_1) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        // Ambil data registrasi
        $reg = $user; // Asumsi user = registrasi (sesuai struktur Anda)

        // Ambil biaya PMB berdasarkan pilihan prodi 1
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
            ->first();

        // Jika tidak ada data biaya, set default
        if (!$biaya) {
            $biaya_pendaftaran = 30000; // Default 30rb
        } else {
            $biaya_pendaftaran = $biaya->biaya_pendaftaran;
        }

        return view('mahasiswa.bayar-pendaftaran', [
            'user' => $user,
            'reg' => $reg,
            'biaya_pendaftaran' => $biaya_pendaftaran
        ]);
    }


    // ======================================
    // 2. BAYAR VIA MIDTRANS (AUTO)
    // ======================================
    public function store()
    {
        $user = request()->user();
        
        // Cek apakah sudah bayar
        if ($user->is_bayar_pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah melakukan pembayaran.');
        }

        // Ambil biaya
        $biaya = BiayaPmb::where('tahun', date('Y'))
            ->where('kodeProdi', $user->kodeProdi_1)
            ->first();

        $jumlah = $biaya ? $biaya->biaya_pendaftaran : 300000;

        // Invoice Number
        $invoice = "INV-PD-" . $user->id . "-" . time();

        $payment = Payment::create([
            'id_registrasi'   => $user->id,
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
                    'name' => "Biaya Pendaftaran PMB",
                ]
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->no_whatsapp ?? '08123456789',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);

            return view('payment.checkout', [
                'snapToken' => $snapToken,
                'payment'   => $payment,
                'user'      => $user,
                'jumlah'    => $jumlah
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }


    // ======================================
    // 3. UPLOAD BUKTI TRANSFER MANUAL
    // ======================================
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'jumlah' => 'required|numeric'
        ], [
            'bukti_bayar.required' => 'Bukti transfer harus diupload',
            'bukti_bayar.image' => 'File harus berupa gambar',
            'bukti_bayar.mimes' => 'Format file harus JPG, PNG, atau JPEG',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB',
        ]);

        $user = request()->user();


        // Cek apakah sudah upload sebelumnya
        if ($user->is_bayar_pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah melakukan pembayaran.');
        }

        // Upload file
        $filename = "bukti-{$user->id}-" . time() . "." . $request->file('bukti_bayar')->extension();
        $path = $request->file('bukti_bayar')->storeAs('bukti-pembayaran', $filename, 'public');

        // Simpan ke database
        Payment::create([
            'id_registrasi'   => $user->id,
            'order_id'        => "INV-MANUAL-" . $user->id . "-" . time(),
            'jumlah'          => $request->jumlah,
            'tipe_pembayaran' => 'pendaftaran',
            'status_transaksi'=> 'manual-upload',
            'bukti_manual'    => $path,
        ]);

        // ✅ Auto Update Step (Jika ingin langsung approve)
        // Atau bisa juga menunggu admin approve manual
        $user->is_bayar_pendaftaran = true;
        $user->save();

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload! Pembayaran Anda sudah terverifikasi.');
    }


    // ======================================
    // 4. WEBHOOK MIDTRANS
    // ======================================
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
                'id_transaksi'     => $notif->transaction_id,
                'payload'          => json_encode($notif),
            ]);

            // ✅ Auto update registrasi step
            $user = Registrasi::find($payment->id_registrasi);
            if ($user) {
                $user->is_bayar_pendaftaran = true;
                $user->save();
            }

        } else if (in_array($notif->transaction_status, ['deny', 'expire', 'cancel'])) {

            $payment->update([
                'status_transaksi' => $notif->transaction_status,
            ]);
        }

        return response('OK', 200);
    }

    // ======================================
    // 5. SELESAI PEMBAYARAN (FINISH PAGE)
    // ======================================
    public function selesai(Request $request)
    {
        $order_id = $request->query('order_id');
        
        if (!$order_id) {
            return redirect()->route('mahasiswa.dashboard');
        }

        $payment = Payment::where('order_id', $order_id)->first();

        return view('payment.finish', [
            'payment' => $payment
        ]);
    }
}