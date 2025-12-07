<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Registrasi;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumentController extends Controller
{
    public function index()
    {
        return view('dokumen.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen.*' => 'required|file|max:5120', // max 5MB
        ]);

        // cari data registrasi berdasarkan user login
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        if (!$registrasi) {
            return back()->with('error', 'Registrasi tidak ditemukan. Silakan lakukan pendaftaran dahulu.');
        }

        foreach ($request->dokumen as $jenis => $file) {

            $namaFile = time() . '_' . $file->getClientOriginalName();
            $format   = $file->getClientOriginalExtension();

            // simpan ke storage/public/dokumen
            $path = $file->storeAs('dokumen', $namaFile, 'public');

            Dokumen::create([
                'idRegistrasi'      => $registrasi->idRegistrasi,
                'jenisDokumen'      => $jenis,
                'namaFile'          => $namaFile,
                'formatFile'        => $format,
                'urlFile'           => '/storage/' . $path,
                'tanggalUpload'     => now(),
                'ukuranVerifikasi'  => null,
                'catatanVerifikasi' => false,
            ]);
        }

        // UPDATE STATUS PMB → "Upload Dokumen = selesai"
        FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
            ->update([
                'is_dokumen_uploaded' => true,
            ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }
}
