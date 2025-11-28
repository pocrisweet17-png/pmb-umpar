<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Registrasi;
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
            'dokumen.*' => 'required|file|max:5120', // 5MB
        ]);

        // 1. Ambil idRegistrasi berdasarkan user yang login
        $registrasi = Registrasi::where('user_id', Auth::id())->first();

        if (!$registrasi) {
            return back()->with('error', 'Registrasi tidak ditemukan. Silakan lakukan pendaftaran dulu.');
        }

        foreach ($request->dokumen as $jenis => $file) {

            $namaFile = time() . '_' . $file->getClientOriginalName();
            $format = $file->getClientOriginalExtension();

            // Simpan file di storage
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

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }
}
