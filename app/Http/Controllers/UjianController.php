<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Ujian;
use App\Models\Jawaban;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user sudah pernah ujian
        $sudahUjian = Ujian::where('idUser', $user->id)
                           ->whereIn('status', ['sedang_berlangsung', 'selesai'])
                           ->exists();

        if ($sudahUjian) {
            // Jika sudah ujian, ambil data ujian terakhir
            $ujian = Ujian::where('idUser', $user->id)
                          ->orderBy('created_at', 'desc')
                          ->first();

            return view('mahasiswa.ujian', [
                'sudahUjian' => true,
                'ujian' => $ujian,
                'soals' => []
            ]);
        }

        // Ambil semua soal untuk ujian
        $soals = Soal::orderBy('idSoal')->get();

        if ($soals->isEmpty()) {
            return redirect()->route('mahasiswa.dashboard')
                           ->with('error', 'Belum ada soal ujian tersedia.');
        }

        return view('mahasiswa.ujian', [
            'sudahUjian' => false,
            'soals' => $soals,
            'ujian' => null
        ]);
    }

    public function submit(Request $request)
    {
        $user = Auth::user();

        // Validasi: cek apakah sudah pernah ujian
        $sudahUjian = Ujian::where('idUser', $user->id)
                           ->whereIn('status', ['sedang_berlangsung', 'selesai'])
                           ->exists();

        if ($sudahUjian) {
            return redirect()->route('mahasiswa.ujian')
                           ->with('error', 'Anda sudah mengikuti ujian sebelumnya.');
        }

        // Validasi input jawaban
        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|in:a,b,c,d'
        ], [
            'jawaban.required' => 'Harap jawab semua soal!',
            'jawaban.*.required' => 'Setiap soal harus dijawab!',
            'jawaban.*.in' => 'Jawaban tidak valid!'
        ]);

        DB::beginTransaction();

        try {
            // Ambil semua soal
            $soals = Soal::all();
            $totalSoal = $soals->count();

            // Validasi: pastikan jumlah jawaban sama dengan jumlah soal
            if (count($request->jawaban) !== $totalSoal) {
                throw new \Exception('Jumlah jawaban tidak sesuai dengan jumlah soal!');
            }

            // Buat record ujian
            $ujian = Ujian::create([
                'idUser' => $user->id,
                'waktuMulai' => now(),
                'waktuSelesai' => now(),
                'status' => 'selesai',
                'nilaiAkhir' => 0,
                'jumlahBenar' => 0,
                'jumlahSalah' => 0
            ]);

            $jumlahBenar = 0;
            $jumlahSalah = 0;

            // Proses setiap jawaban
            foreach ($request->jawaban as $idSoal => $jawabanUser) {
                $soal = $soals->firstWhere('idSoal', $idSoal);

                if (!$soal) {
                    continue;
                }

                // Simpan jawaban ke tabel jawabans
                Jawaban::create([
                    'idUjian' => $ujian->idUjian,
                    'idSoal' => $idSoal,
                    'JawabanPeserta' => $jawabanUser
                ]);

                // Hitung benar/salah
                if (strtolower($soal->jawabanBenar) === strtolower($jawabanUser)) {
                    $jumlahBenar++;
                } else {
                    $jumlahSalah++;
                }
            }

            // Hitung nilai akhir (skala 0-100)
            $nilaiAkhir = ($jumlahBenar / $totalSoal) * 100;

            // Update data ujian
            $ujian->update([
                'nilaiAkhir' => round($nilaiAkhir, 2),
                'jumlahBenar' => $jumlahBenar,
                'jumlahSalah' => $jumlahSalah
            ]);

            // Simpan ke leaderboard
            Leaderboard::create([
                'idUser' => $user->id,
                'idUjian' => $ujian->idUjian,
                'nilai' => round($nilaiAkhir, 2)
            ]);

            DB::commit();

            // Redirect ke halaman hasil
            return redirect()->route('mahasiswa.hasil', ['idUjian' => $ujian->idUjian])
                           ->with('success', 'Ujian berhasil diselesaikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mahasiswa.ujian')
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function hasil($idUjian)
{
    $ujian = Ujian::with('user')->findOrFail($idUjian);

    // Pastikan user hanya bisa melihat hasil ujiannya sendiri
    if ($ujian->idUser !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Hitung ranking
    $ranking = Leaderboard::where('nilai', '>', $ujian->nilaiAkhir)->count() + 1;

    // Cek lulus/tidak
    $lulus = $ujian->nilaiAkhir >= 70;

    return view('mahasiswa.hasil', compact('ujian', 'ranking', 'lulus'));
}
}
