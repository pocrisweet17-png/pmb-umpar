<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaPmb;
use App\Models\ProgramStudy;

class BiayaPmbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BiayaPmb::with('programStudi');

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter by kodeProdi
        if ($request->filled('kodeProdi')) {
            $query->where('kodeProdi', $request->kodeProdi);
        }

        $biayaPmb = $query->orderBy('tahun', 'desc')
                          ->orderBy('kodeProdi', 'asc')
                          ->get();

        $programStudis = ProgramStudy::orderBy('namaProdi', 'asc')->get();

        return view('admin.biaya-pmb.index', compact('biayaPmb', 'programStudis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2100',
            'kodeProdi' => 'required|exists:program_studis,kodeProdi',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'biaya_ukt' => 'required|numeric|min:0',
        ]);

        // Cek duplikasi tahun + kodeProdi
        $exists = BiayaPmb::where('tahun', $validated['tahun'])
                          ->where('kodeProdi', $validated['kodeProdi'])
                          ->exists();

        if ($exists) {
            return redirect()->route('admin.biaya-pmb.index')
                ->with('error', 'Biaya untuk tahun dan program studi ini sudah ada!');
        }

        BiayaPmb::create($validated);

        return redirect()->route('admin.biaya-pmb.index')
            ->with('success', 'Biaya PMB berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $biaya = BiayaPmb::findOrFail($id);

        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2100',
            'kodeProdi' => 'required|exists:program_studis,kodeProdi',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'biaya_ukt' => 'required|numeric|min:0',
        ]);

        // Cek duplikasi tahun + kodeProdi (kecuali data ini sendiri)
        $exists = BiayaPmb::where('tahun', $validated['tahun'])
                          ->where('kodeProdi', $validated['kodeProdi'])
                          ->where('id', '!=', $id)
                          ->exists();

        if ($exists) {
            return redirect()->route('admin.biaya-pmb.index')
                ->with('error', 'Biaya untuk tahun dan program studi ini sudah ada!');
        }

        $biaya->update($validated);

        return redirect()->route('admin.biaya-pmb.index')
            ->with('success', 'Biaya PMB berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $biaya = BiayaPmb::findOrFail($id);
        $biaya->delete();

        return redirect()->route('admin.biaya-pmb.index')
            ->with('success', 'Biaya PMB berhasil dihapus!');
    }
}