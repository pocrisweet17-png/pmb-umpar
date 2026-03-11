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
     * - Role lain     : melihat semua mahasiswa (tampilan flat seperti semula).
     */
    public function daftarUlang(Request $request)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';

        // ── Base query ───────────────────────────────────────────────────────────
        $query = Mahasiswa::with(['user', 'user.dokumens', 'programStudi', 'registrasi'])
            ->where('is_daftar_ulang', true);

        // ── Filter khusus Dekan: hanya prodi di fakultasnya ──────────────────────
        if ($isDekan && $user->fakultas_id) {
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')
                ->toArray();

            $query->whereIn('kodeProdi', $kodeProdiDiFakultas);
        }

        // ── Filter pencarian opsional ─────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('namaLengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%");
            });
        }

        // ── Filter status opsional ────────────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status_daftar_ulang', $request->status);
        }

        // ── Ambil data ────────────────────────────────────────────────────────────
        if ($isDekan) {
            $allData    = $query->orderBy('kodeProdi')->orderBy('namaLengkap')->get();
            $mahasiswas = null;
        } else {
            $allData    = $query->orderBy('created_at', 'desc')->get();
            $mahasiswas = $query->orderBy('created_at', 'desc')->paginate(20);
        }

        // ── Statistik ─────────────────────────────────────────────────────────────
        $stats = [
            'total'    => $allData->count(),
            'verified' => $allData->where('status_daftar_ulang', 'verified')->count(),
            'pending'  => $allData->where('status_daftar_ulang', 'pending')->count(),
            'rejected' => $allData->where('status_daftar_ulang', 'rejected')->count(),
        ];

        // ── Mode Dekan: kelompokkan per prodi ─────────────────────────────────────
        $mahasiswaPerProdi = null;
        $namaFakultas      = null;

        if ($isDekan) {
            $mahasiswaPerProdi = $allData
                ->groupBy('kodeProdi')
                ->map(function ($items, $kodeProdi) {
                    return [
                        'namaProdi'  => optional($items->first()->programStudi)->namaProdi ?? $kodeProdi,
                        'kodeProdi'  => $kodeProdi,
                        'mahasiswas' => $items,
                        'stats'      => [
                            'total'    => $items->count(),
                            'verified' => $items->where('status_daftar_ulang', 'verified')->count(),
                            'pending'  => $items->where('status_daftar_ulang', 'pending')->count(),
                            'rejected' => $items->where('status_daftar_ulang', 'rejected')->count(),
                        ],
                    ];
                })
                ->sortBy('namaProdi')
                ->values();

            $namaFakultas = \App\Models\Fakultas::find($user->fakultas_id)?->nama_fakultas
                         ?? ($user->fakultas_id ? "Fakultas ID-{$user->fakultas_id}" : 'Belum Ditugaskan');
        }

        return view('admin.Mahasiswa.data-mahasiswa', compact(
            'mahasiswas',
            'mahasiswaPerProdi',
            'stats',
            'isDekan',
            'namaFakultas',
        ));
    }

    /**
     * Download dokumen milik mahasiswa tertentu.
     * Dekan hanya boleh download dokumen mahasiswa di fakultasnya sendiri.
     */
    public function downloadDokumen($mahasiswaId, $dokumenId)
    {
        $user    = auth()->user()->loadMissing('fakultas');
        $isDekan = $user->role === 'dekan';

        $mahasiswa = Mahasiswa::with('programStudi')->findOrFail($mahasiswaId);

        // Guard: dekan hanya boleh akses fakultasnya sendiri
        if ($isDekan && $user->fakultas_id) {
            $kodeProdiDiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                ->pluck('kodeProdi')
                ->toArray();

            abort_unless(in_array($mahasiswa->kodeProdi, $kodeProdiDiFakultas), 403, 'Akses ditolak.');
        }

        $dokumen = Dokumen::where('idDokumen', $dokumenId)
            ->where('user_id', $mahasiswa->user_id)
            ->firstOrFail();

        abort_unless(Storage::disk('public')->exists($dokumen->urlFile), 404, 'File tidak ditemukan.');

        return Storage::disk('public')->download(
            $dokumen->urlFile,
            $dokumen->namaFile
        );
    }

    /**
     * Export semua data mahasiswa daftar ulang ke Excel.
     */
    public function exportExcel()
    {
        $fileName = 'Data_Mahasiswa_Daftar_Ulang_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new MahasiswaExport(), $fileName);
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
    public function rejectDaftarUlang(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->update([
            'status_daftar_ulang' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Daftar ulang ditolak!');
    }
}