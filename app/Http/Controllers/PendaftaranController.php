<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\FormulirPendaftaran;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenisKelamin'  => 'required|string',
            'tempatLahir'   => 'required|string',
            'tanggalLahir'  => 'required|date',
            'agama'         => 'required|string',
            'alamat'        => 'required|string',
            'asalSekolah'   => 'required|string',
            'jurusan'       => 'required|string',
            'tahunLulus'    => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $user = Auth::user();

        // Cek apakah data lengkap sudah pernah diisi
        if (Registrasi::where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Data pribadi sudah pernah diisi.');
        }

        // SIMPAN ke tabel registrasis
        $registrasi = Registrasi::create([
            'user_id'          => $user->id,
            'nomorPendaftaran' => $user->nomorRegistrasi, // dari table users

            'jenisKelamin'     => $request->jenisKelamin,
            'tempatLahir'      => $request->tempatLahir,
            'tanggalLahir'     => $request->tanggalLahir,
            'agama'            => $request->agama,
            'alamat'           => $request->alamat,
            'asalSekolah'      => $request->asalSekolah,
            'jurusan'          => $request->jurusan,
            'tahunLulus'       => $request->tahunLulus,

            'tanggalDaftar'    => now(),
            'statusRegistrasi' => 'pending',
        ]);

        // UPDATE status step pada formulir_pendaftarans
        FormulirPendaftaran::where('user_id', $user->id)->update([
            'is_data_completed' => true,
        ]);

        return back()->with('success', 'Data pribadi berhasil disimpan.');
    }
}
