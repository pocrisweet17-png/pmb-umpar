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
        $prodi1 = ProgramStudy::where('kodeProdi', $request->pilihan_1)->first();

        if (!$prodi1) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi pilihan 1 tidak ditemukan'
            ], 422);
        }

        $rules = [
            'pilihan_1' => 'required|string',
        ];

        $messages = [
            'pilihan_1.required' => 'Pilihan 1 harus diisi',
        ];

        // Untuk S1 dan S2, wajibkan pilihan 2
        if (!in_array($prodi1->jenjang, ['S3', 'Profesi'])) {
            $rules['pilihan_2'] = 'required|string|different:pilihan_1';
            $messages['pilihan_2.required'] = 'Pilihan 2 harus diisi';
            $messages['pilihan_2.different'] = 'Pilihan 1 dan 2 tidak boleh sama';
        } else {
            // Untuk S3 dan Profesi, pilihan 2 opsional
            $rules['pilihan_2'] = 'nullable|string|different:pilihan_1';
            $messages['pilihan_2.different'] = 'Pilihan 1 dan 2 tidak boleh sama';
        }

        $validated = $request->validate($rules, $messages);

        // Cek prodi2 hanya jika ada
        $prodi2 = null;
        if (!empty($validated['pilihan_2'])) {
            $prodi2 = ProgramStudy::where('kodeProdi', $validated['pilihan_2'])->first();

            if (!$prodi2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program studi pilihan 2 tidak ditemukan'
                ], 422);
            }

            // Validasi: jenjang harus sama (hanya jika ada pilihan 2)
            if ($prodi1->jenjang !== $prodi2->jenjang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kedua pilihan harus dari jenjang yang sama'
                ], 422);
            }
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan. Silakan login kembali.'
            ], 401);
        }

        // Update data user - pilihan_2 bisa null untuk S3/Profesi
        $user->update([
            'pilihan_1'         => $validated['pilihan_1'],
            'pilihan_2'         => $validated['pilihan_2'] ?? null,
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
        $jenjang = $request->query('jenjang'); 

        if (!$fakultas) {
            return response()->json([]);
        }

        $query = ProgramStudy::where('fakultas', $fakultas);

        // Filter berdasarkan jenjang
        if ($jenjang) {
            $query->where('jenjang', $jenjang);
        }

        $prodi = $query->select('kodeProdi', 'namaProdi', 'jenjang')->get();

    return response()->json($prodi);
    }
}
