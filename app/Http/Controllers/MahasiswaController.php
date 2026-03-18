<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudy;
use App\Models\Dokumen;
use App\Exports\MahasiswaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang sudah daftar ulang.
     * - Role 'dekan'  : hanya melihat mahasiswa di fakultasnya, dikelompokkan per prodi.
     * - Role lain     : melihat semua mahasiswa (tampilan flat + pagination).
     */
    public function daftarUlang(Request $request)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';
        $isPimpinan = $user->role === 'pimpinan';

        // ── Base query ────────────────────────────────────────────────────────────
        $baseQuery = Mahasiswa::with(['user', 'user.dokumens', 'programStudi', 'registrasi'])
            ->where('is_daftar_ulang', true);

        // ── Guard: Dekan hanya lihat prodi di fakultasnya ─────────────────────────
        $kodeDekan             = null;
        $namaFakultas          = null;
        $kodeProdiDiFakultas   = [];

        if ($isDekan && $user->fakultas_id) {
            $fakultas = \App\Models\Fakultas::find($user->fakultas_id);
            $namaFakultas        = $fakultas?->nama_fakultas ?? "Fakultas ID-{$user->fakultas_id}";
            $kodeDekan           = $user->fakultas_id;
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')
                ->toArray();

            $baseQuery->whereIn('kodeProdi', $kodeProdiDiFakultas);
        }

        // ── Ambil SEMUA data (untuk stats + dekan grouping) ───────────────────────
        // Clone query sebelum pagination agar tidak double-query dengan kondisi berbeda
        $allData = (clone $baseQuery)->orderBy('kodeProdi')->orderBy('namaLengkap')->get();

        // ── Stats berdasarkan allData ─────────────────────────────────────────────
        $stats = [
            'total'    => $allData->count(),
            'verified' => $allData->where('status_daftar_ulang', 'verified')->count(),
            'pending'  => $allData->where('status_daftar_ulang', 'pending')->count(),
            'rejected' => $allData->where('status_daftar_ulang', 'rejected')->count(),
        ];

        // ── Paginated data untuk mode Admin ──────────────────────────────────────
        $mahasiswas = $isDekan
            ? collect()   // dekan tidak pakai pagination
            : (clone $baseQuery)->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // ── Mode Dekan: kelompokkan per prodi ────────────────────────────────────
        $mahasiswaPerProdi = null;

        if ($isDekan) {
            $mahasiswaPerProdi = $allData
                ->groupBy('kodeProdi')
                ->map(fn($items, $kodeProdi) => [
                    'namaProdi'  => optional($items->first()->programStudi)->namaProdi ?? $kodeProdi,
                    'kodeProdi'  => $kodeProdi,
                    'mahasiswas' => $items,
                    'stats'      => [
                        'total'    => $items->count(),
                        'verified' => $items->where('status_daftar_ulang', 'verified')->count(),
                        'pending'  => $items->where('status_daftar_ulang', 'pending')->count(),
                        'rejected' => $items->where('status_daftar_ulang', 'rejected')->count(),
                    ],
                ])
                ->sortBy('namaProdi')
                ->values();
        }

        // ── Dropdown: daftar prodi (untuk filter admin) ───────────────────────────
        $prodiQuery = ProgramStudy::orderBy('namaProdi');
        if ($isDekan && !empty($kodeProdiDiFakultas)) {
            $prodiQuery->whereIn('kodeProdi', $kodeProdiDiFakultas);
        }
        $prodiList = $prodiQuery->get(['kodeProdi', 'namaProdi']);

        // ── Dropdown: daftar angkatan ─────────────────────────────────────────────
        $angkatanQuery = Mahasiswa::where('is_daftar_ulang', true)
            ->when($isDekan && !empty($kodeProdiDiFakultas), fn($q) => $q->whereIn('kodeProdi', $kodeProdiDiFakultas))
            ->orderByDesc('angkatan')
            ->distinct()
            ->pluck('angkatan');

        $angkatanList = $angkatanQuery;

        return view('admin.Mahasiswa.data-mahasiswa', compact(
            'mahasiswas',
            'mahasiswaPerProdi',
            'stats',
            'isDekan',
            'isPimpinan',    
            'namaFakultas',
            'kodeDekan',
            'prodiList',
            'angkatanList',
        ));
    }

    /**
     * Preview dokumen (inline di browser — untuk iframe / img tag).
     */
    public function previewDokumen($mahasiswaId, $dokumenId)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';

        $mahasiswa = Mahasiswa::with('programStudi')->findOrFail($mahasiswaId);

        if ($isDekan && $user->fakultas_id) {
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')->toArray();
            abort_unless(in_array($mahasiswa->kodeProdi, $kodeProdiDiFakultas), 403);
        }

        $dokumen = Dokumen::where('idDokumen', $dokumenId)
            ->where('user_id', $mahasiswa->user_id)
            ->firstOrFail();

        abort_unless(Storage::disk('public')->exists($dokumen->urlFile), 404, 'File tidak ditemukan.');

        $path = Storage::disk('public')->path($dokumen->urlFile);
        $mime = Storage::disk('public')->mimeType($dokumen->urlFile);

        return response()->file($path, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $dokumen->namaFile . '"',
        ]);
    }

    /**
     * Download satu dokumen milik mahasiswa.
     */
    public function downloadDokumen($mahasiswaId, $dokumenId)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';

        $mahasiswa = Mahasiswa::with('programStudi')->findOrFail($mahasiswaId);

        if ($isDekan && $user->fakultas_id) {
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')->toArray();
            abort_unless(in_array($mahasiswa->kodeProdi, $kodeProdiDiFakultas), 403, 'Akses ditolak.');
        }

        $dokumen = Dokumen::where('idDokumen', $dokumenId)
            ->where('user_id', $mahasiswa->user_id)
            ->firstOrFail();

        abort_unless(Storage::disk('public')->exists($dokumen->urlFile), 404, 'File tidak ditemukan.');

        return Storage::disk('public')->download($dokumen->urlFile, $dokumen->namaFile);
    }

    /**
     * Download semua dokumen mahasiswa sebagai ZIP.
     */
    public function downloadZip($mahasiswaId)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';

        $mahasiswa = Mahasiswa::with(['programStudi', 'user.dokumens'])->findOrFail($mahasiswaId);

        if ($isDekan && $user->fakultas_id) {
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')->toArray();
            abort_unless(in_array($mahasiswa->kodeProdi, $kodeProdiDiFakultas), 403);
        }

        $dokumens = $mahasiswa->user->dokumens ?? collect();
        abort_if($dokumens->isEmpty(), 404, 'Tidak ada dokumen.');

        $zipName = 'Dokumen_' . $mahasiswa->nim . '_' . date('Ymd') . '.zip';
        $tempDir = storage_path('app/temp');

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/' . $zipName;
        $zip     = new \ZipArchive();

        abort_unless($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true, 500);

        foreach ($dokumens as $dok) {
            if (Storage::disk('public')->exists($dok->urlFile)) {
                $zip->addFile(
                    Storage::disk('public')->path($dok->urlFile),
                    $dok->namaFile
                );
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /**
     * Export data mahasiswa daftar ulang ke Excel.
     * Mendukung filter: ?prodi=XX &status=XX &angkatan=XX &q=XX &fakultas=XX
     */
    public function exportExcel(Request $request)
    {
        $fileName = 'Data_Mahasiswa_Daftar_Ulang_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new MahasiswaExport($request->all()), $fileName);
    }

    /**
     * Verifikasi daftar ulang mahasiswa.
     */
    public function verifyDaftarUlang($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'status_daftar_ulang' => 'verified',
            'statusMahasiswa'     => 'aktif',
        ]);

        $mahasiswa->user->update([
            'is_daftar_ulang' => true,
        ]);

        return redirect()->back()->with('success', 'Daftar ulang berhasil diverifikasi!');
    }

    /**
     * Tolak daftar ulang mahasiswa.
     */
    public function rejectDaftarUlang($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'status_daftar_ulang' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Daftar ulang ditolak.');
    }
}