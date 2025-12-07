<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = ProgramStudy::all();
        return view('mahasiswa.pilih-prodi-modal', compact('prodi'));
    }

    public function show()
    {
        // Ambil daftar fakultas unik
        $fakultas = ProgramStudy::select('fakultas')->distinct()->get();

        return view('mahasiswa.pilih-prodi-modal', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pilihan_1' => 'required',
            'pilihan_2' => 'required|different:pilihan_1',
        ]);

        $user = request()->user();

        // Simpan pilihan prodi ke tabel users 
        $user->update([
            'pilihan_1' => $request->pilihan_1,
            'pilihan_2' => $request->pilihan_2,
        ]);

        // Update langkah ke tabel registrasis 
        $user->update([
            'is_prodi_selected' => true,
        ]);


        // Lanjut ke pembayaran
        return redirect()
            ->route('bayar.index')
            ->with('success', 'Pilihan program studi berhasil disimpan. Silakan lakukan pembayaran.');
    }

    // === AJAX untuk dropdown Prodi berdasarkan Fakultas ===
    public function getProdiByFakultas(Request $request)
    {
        $fakultas = $request->query('fakultas');

        if (!$fakultas) {
            return response()->json([]);
        }

        $prodi = ProgramStudy::where('fakultas', $fakultas)
                    ->select('kodeProdi', 'namaProdi')
                    ->get();

        return response()->json($prodi);
    }

    // Opsional API versi cepat
    public function apiGetProdi(Request $request)
    {
        return ProgramStudy::where('fakultas', $request->fakultas)->get();
    }
}
