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
        // Ambil daftar fakultas (unique)
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
        $user->update([
            'pilihan_1' => $request->pilihan_1,
            'pilihan_2' => $request->pilihan_2,
            'is_prodi_selected' => true,
        ]);

        // return redirect()->route('mahasiswa.dashboard')
        //     ->with('success', 'Pilihan program studi berhasil disimpan.');
            return redirect()->route('payment.show')->with('success', 'Silakan lakukan pembayaran.');
    }

    // dipakai untuk AJAX saat memilih fakultas
    public function getProdiByFakultas(Request $request)
{
    $fakultas = $request->query('fakultas');

    if (!$fakultas) {
        return response()->json([]);
    }

    $prodi = ProgramStudy::where('fakultas', $fakultas)
                ->select('kodeProdi', 'namaProdi') // lebih ringan
                ->get();

    return response()->json($prodi);
}
    public function apiGetProdi(Request $request)
    {
    return ProgramStudy::where('fakultas', $request->fakultas)->get();
    }

}
