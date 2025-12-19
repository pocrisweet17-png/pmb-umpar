<?php

namespace App\Http\Controllers;

use update;
use App\Models\Soal;
use App\Models\Ujian;
use App\Models\Jawaban;
use App\Models\Registrasi;
use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormulirPendaftaran;
use Illuminate\Support\Facades\Auth;

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

    $sudahUjian = Ujian::where('idUser', $user->id)
                       ->whereIn('status', ['sedang_berlangsung', 'selesai'])
                       ->exists();

    if ($sudahUjian) {
        return redirect()->route('mahasiswa.ujian')
                       ->with('error', 'Anda sudah mengikuti ujian sebelumnya.');
    }

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
        $soals = Soal::all();
        $totalSoal = $soals->count();

        if (count($request->jawaban) !== $totalSoal) {
            throw new \Exception('Jumlah jawaban tidak sesuai dengan jumlah soal!');
        }

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

        foreach ($request->jawaban as $idSoal => $jawabanUser) {
            $soal = $soals->firstWhere('idSoal', $idSoal);

            if (!$soal) {
                continue;
            }

            Jawaban::create([
                'idUjian' => $ujian->idUjian,
                'idSoal' => $idSoal,
                'JawabanPeserta' => $jawabanUser
            ]);

            if (strtolower($soal->jawabanBenar) === strtolower($jawabanUser)) {
                $jumlahBenar++;
            } else {
                $jumlahSalah++;
            }
        }

        $nilaiAkhir = ($jumlahBenar / $totalSoal) * 100;

        $ujian->update([
            'nilaiAkhir' => round($nilaiAkhir, 2),
            'jumlahBenar' => $jumlahBenar,
            'jumlahSalah' => $jumlahSalah
        ]);

        Leaderboard::create([
            'idUser' => $user->id,
            'idUjian' => $ujian->idUjian,
            'nilai' => round($nilaiAkhir, 2)
        ]);

        
        $user->update(['is_tes_selesai' => true]);
        
        $registrasi = Registrasi::where('user_id', $user->id)->first();
        if ($registrasi) {
            User::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
                ->update(['is_tes_selesai' => true]);
        }

        DB::commit();

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
    $lulus = $ujian->nilaiAkhir >= 10;

    return view('mahasiswa.hasil', compact('ujian', 'ranking', 'lulus'));
}
}
