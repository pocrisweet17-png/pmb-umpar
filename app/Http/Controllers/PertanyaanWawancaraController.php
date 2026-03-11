<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PertanyaanWawancara;
use Illuminate\Http\Request;

class PertanyaanWawancaraController extends Controller
{
    public function index()
    {
        $pertanyaans = PertanyaanWawancara::orderBy('id')->get();
        return view('admin.wawancara.index', compact('pertanyaans'));
    }

    public function create()
    {
        return view('admin.wawancara.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
        ]);

        PertanyaanWawancara::create($validated);

        return redirect()->route('admin.wawancara.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pertanyaan = PertanyaanWawancara::findOrFail($id);
        return view('admin.wawancara.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $pertanyaan = PertanyaanWawancara::findOrFail($id);
        $pertanyaan->update($validated);

        return redirect()->route('admin.wawancara.index')
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pertanyaan = PertanyaanWawancara::findOrFail($id);
        $pertanyaan->delete();

        return redirect()->route('admin.wawancara.index')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $pertanyaan = PertanyaanWawancara::findOrFail($id);
        $pertanyaan->update(['is_active' => !$pertanyaan->is_active]);

        return redirect()->route('admin.wawancara.index')
            ->with('success', 'Status pertanyaan berhasil diubah!');
    }
}