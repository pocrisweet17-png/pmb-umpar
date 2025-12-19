<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdiController extends Controller
{
    public function show()
    {
        $fakultas = ProgramStudy::select('fakultas')->distinct()->get();
        return view('mahasiswa.pilih-prodi-modal', compact('fakultas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pilihan_1' => 'required|string',
            'pilihan_2' => 'required|string|different:pilihan_1',
        ], [
            'pilihan_1.required' => 'Pilihan 1 harus diisi',
            'pilihan_2.required' => 'Pilihan 2 harus diisi',
            'pilihan_2.different' => 'Pilihan 1 dan 2 tidak boleh sama',
        ]);

        // Cek prodi valid
        $prodi1 = ProgramStudy::where('kodeProdi', $validated['pilihan_1'])->first();
        $prodi2 = ProgramStudy::where('kodeProdi', $validated['pilihan_2'])->first();
            
        if (!$prodi1) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi pilihan 1 tidak ditemukan'
            ], 422);
        }

        if (!$prodi2) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi pilihan 2 tidak ditemukan'
            ], 422);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan. Silakan login kembali.'
            ], 401);
        }

        // Update data user
        $user->update([
            'pilihan_1'         => $validated['pilihan_1'],
            'pilihan_2'         => $validated['pilihan_2'],
            'is_prodi_selected' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pilihan program studi berhasil disimpan',
            'redirect' => route('mahasiswa.dashboard')
        ]);
    }

    public function getProdiByFakultas(Request $request)
    {
        $fakultas = $request->query('fakultas');

        if (!$fakultas) {
            return response()->json([]);
        }

        $prodi = ProgramStudy::where('fakultas', $fakultas)
                    ->select('kodeProdi', 'namaProdi', 'jenjang')
                    ->get();

        return response()->json($prodi);
    }
}
