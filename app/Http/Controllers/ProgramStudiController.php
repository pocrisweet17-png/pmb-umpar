<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Log;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProgramStudy::query();

        // Filter by fakultas
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        // Filter by jenjang
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kodeProdi', 'LIKE', "%{$search}%")
                  ->orWhere('namaProdi', 'LIKE', "%{$search}%")
                  ->orWhere('fakultas', 'LIKE', "%{$search}%");
            });
        }

        $programStudis = $query->orderBy('fakultas', 'asc')
                            ->orderBy('jenjang', 'asc')
                            ->orderBy('namaProdi', 'asc')
                            ->paginate(10)->withQueryString();

        // Get unique fakultas for filter
        $fakultasList = ProgramStudy::select('fakultas')
                                    ->distinct()
                                    ->orderBy('fakultas')
                                    ->pluck('fakultas');

        $totalProdi = ProgramStudy::count();
        $totalS1    = ProgramStudy::where('jenjang', 'S1')->count();
        $totalS2    = ProgramStudy::where('jenjang', 'S2')->count();
        $totalS3    = ProgramStudy::where('jenjang', 'S3')->count();

        return view('admin.program-study.index', compact(
            'programStudis', 'fakultasList',
            'totalProdi', 'totalS1', 'totalS2', 'totalS3'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kodeProdi' => 'required|string|max:50|unique:program_studis,kodeProdi',
            'namaProdi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|in:S1,S2,S3',
            'kuota' => 'required|integer|min:0',
        ], [
            'kodeProdi.required' => 'Kode Prodi wajib diisi',
            'kodeProdi.unique' => 'Kode Prodi sudah digunakan',
            'namaProdi.required' => 'Nama Prodi wajib diisi',
            'fakultas.required' => 'Fakultas wajib diisi',
            'jenjang.required' => 'Jenjang wajib diisi',
            'jenjang.in' => 'Jenjang harus salah satu dari: S1, S2, S3',
            'kuota.required' => 'Kuota wajib diisi', 
            'kuota.integer' => 'Kuota harus berupa angka',
            'kuota.min' => 'Kuota minimal 0',
        ]);

        try {
            ProgramStudy::create($validated);

            Log::info('Program Studi created', [
                'kodeProdi' => $validated['kodeProdi'],
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('success', 'Program Studi berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Failed to create Program Studi', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('error', 'Gagal menambahkan Program Studi: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kodeProdi)
    {
        $programStudi = ProgramStudy::where('kodeProdi', $kodeProdi)->firstOrFail();

        $validated = $request->validate([
            'kodeProdi' => 'required|string|max:50|unique:program_studis,kodeProdi,' . $kodeProdi . ',kodeProdi',
            'namaProdi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|in:S1,S2,S3',
            'kuota' => 'required|integer|min:0',
        ], [
            'kodeProdi.required' => 'Kode Prodi wajib diisi',
            'kodeProdi.unique' => 'Kode Prodi sudah digunakan',
            'namaProdi.required' => 'Nama Prodi wajib diisi',
            'fakultas.required' => 'Fakultas wajib diisi',
            'jenjang.required' => 'Jenjang wajib diisi',
            'jenjang.in' => 'Jenjang harus salah satu dari: S1, S2, S3',
        ]);

        try {
            $oldKodeProdi = $programStudi->kodeProdi;

            $programStudi->update($validated);

            Log::info('Program Studi updated', [
                'old_kodeProdi' => $oldKodeProdi,
                'new_kodeProdi' => $validated['kodeProdi'],
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('success', 'Program Studi berhasil diupdate!');
        } catch (\Exception $e) {
            Log::error('Failed to update Program Studi', [
                'error' => $e->getMessage(),
                'kodeProdi' => $kodeProdi
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('error', 'Gagal mengupdate Program Studi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kodeProdi)
    {
        try {
            $programStudi = ProgramStudy::where('kodeProdi', $kodeProdi)->firstOrFail();

            // Cek apakah ada user yang terdaftar di prodi ini
            $userCount = \App\Models\User::where('pilihan_1', $kodeProdi)
                                         ->orWhere('pilihan_2', $kodeProdi)
                                         ->count();

            if ($userCount > 0) {
                return redirect()->route('admin.program-studi.index')
                    ->with('error', "Tidak dapat menghapus! Ada {$userCount} mahasiswa terdaftar di program studi ini.");
            }

            // Cek apakah ada biaya PMB terkait
            $biayaCount = \App\Models\BiayaPmb::where('kodeProdi', $kodeProdi)->count();

            if ($biayaCount > 0) {
                return redirect()->route('admin.program-studi.index')
                    ->with('error', "Tidak dapat menghapus! Ada {$biayaCount} data biaya PMB terkait program studi ini.");
            }

            $programStudi->delete();

            Log::info('Program Studi deleted', [
                'kodeProdi' => $kodeProdi,
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('success', 'Program Studi berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete Program Studi', [
                'error' => $e->getMessage(),
                'kodeProdi' => $kodeProdi
            ]);

            return redirect()->route('admin.program-studi.index')
                ->with('error', 'Gagal menghapus Program Studi: ' . $e->getMessage());
        }
    }
}