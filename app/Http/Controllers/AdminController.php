<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\PertanyaanWawancara;
use App\Models\Wawancara;
use App\Models\Registrasi;
use App\Models\ProgramStudy;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Cek apakah user adalah pimpinan
        $isPimpinan = ($user->role === 'pimpinan');
        
        // ── Base Query dengan Filter Role ──────────────────────────────────────
        $baseQuery = User::query();
        
        // Filter untuk role dekan - hanya lihat data fakultasnya
        if ($user->role === 'dekan' && $user->fakultas_id) {
            $kodeProdiFakultas = ProgramStudy::where('fakultas_id', $user->fakultas_id)
                                            ->pluck('kodeProdi')
                                            ->toArray();
            
            $baseQuery->where(function($q) use ($kodeProdiFakultas) {
                $q->whereIn('pilihan_1', $kodeProdiFakultas)
                  ->orWhereIn('pilihan_2', $kodeProdiFakultas);
            });
        }
        
        // ── Statistik Dasar ─────────────────────────────────────────────────────
        $totalSoal = Soal::count();
        $totalUser = (clone $baseQuery)->where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPimpinan = User::where('role', 'pimpinan')->count();
        $totalUserVerified = (clone $baseQuery)->where('is_verified', true)->count();
        $totalUjian = Ujian::count();
        $ujianSelesai = Ujian::where('status', 'selesai')->count();
        $totalPertanyaanWawancara = PertanyaanWawancara::where('is_active', true)->count();

        // ── Statistik Mahasiswa (sudah punya NIM) ───────────────────────────────
        // Mahasiswa per Fakultas (sudah punya NIM)
        $mahasiswaPerFakultas = Mahasiswa::join('program_studis', 'mahasiswas.kodeProdi', '=', 'program_studis.kodeProdi')
            ->select('program_studis.fakultas', DB::raw('COUNT(*) as total'))
            ->whereNotNull('mahasiswas.nim')
            ->where('mahasiswas.nim', '!=', '')
            ->groupBy('program_studis.fakultas')
            ->orderByDesc('total')
            ->pluck('total', 'fakultas')
            ->toArray();
        
        // Mahasiswa per Program Studi (sudah punya NIM)
        $mahasiswaPerProdi = Mahasiswa::join('program_studis', 'mahasiswas.kodeProdi', '=', 'program_studis.kodeProdi')
            ->select('program_studis.namaProdi', DB::raw('COUNT(*) as total'))
            ->whereNotNull('mahasiswas.nim')
            ->where('mahasiswas.nim', '!=', '')
            ->groupBy('program_studis.namaProdi')
            ->orderByDesc('total')
            ->pluck('total', 'namaProdi')
            ->toArray();

        // ── Ambil user_ids untuk filter ─────────────────────────────────────────
        $userIds = (clone $baseQuery)->where('role', 'user')->pluck('id')->toArray();
        $mahasiswaUserIds = User::where('role', 'user')
            ->whereNotNull('nim')
            ->where('nim', '!=', '')
            ->pluck('id')
            ->toArray();

        // ── Statistik Asal Daerah (Semua Pendaftar) ─────────────────────────────
        $registrations = Registrasi::select('alamat')
            ->whereIn('user_id', $userIds)
            ->whereNotNull('alamat')
            ->where('alamat', '!=', '')
            ->get();
        
        $regionStats = [];
        foreach ($registrations as $reg) {
            $addressParts = array_map('trim', explode(',', $reg->alamat));
            if (isset($addressParts[3]) && !empty(trim($addressParts[3]))) {
                $city = strtoupper(trim($addressParts[3]));
                $city = $this->formatCityName($city);
                if (!empty($city)) {
                    $regionStats[$city] = ($regionStats[$city] ?? 0) + 1;
                }
            }
        }
        arsort($regionStats);

        // ── Statistik Asal Daerah (Mahasiswa yang sudah punya NIM) ──────────────
        $mahasiswaRegistrations = Registrasi::select('alamat')
            ->whereIn('user_id', $mahasiswaUserIds)
            ->whereNotNull('alamat')
            ->where('alamat', '!=', '')
            ->get();
        
        $mahasiswaRegionStats = [];
        foreach ($mahasiswaRegistrations as $reg) {
            $addressParts = array_map('trim', explode(',', $reg->alamat));
            if (isset($addressParts[3]) && !empty(trim($addressParts[3]))) {
                $city = strtoupper(trim($addressParts[3]));
                $city = $this->formatCityName($city);
                if (!empty($city)) {
                    $mahasiswaRegionStats[$city] = ($mahasiswaRegionStats[$city] ?? 0) + 1;
                }
            }
        }
        arsort($mahasiswaRegionStats);

        // ── Statistik Jenis Kelamin (Semua Pendaftar) ───────────────────────────
        $genderStatsRaw = Registrasi::select('jenisKelamin', DB::raw('count(*) as total'))
            ->whereIn('user_id', $userIds)
            ->whereNotNull('jenisKelamin')
            ->where('jenisKelamin', '!=', '')
            ->groupBy('jenisKelamin')
            ->pluck('total', 'jenisKelamin')
            ->toArray();
        
        $genderStats = [];
        foreach ($genderStatsRaw as $gender => $count) {
            $label = $this->formatGenderLabel($gender);
            $genderStats[$label] = ($genderStats[$label] ?? 0) + $count;
        }

        // ── Statistik Jenis Kelamin (Mahasiswa yang sudah punya NIM) ────────────
        $mahasiswaGenderStatsRaw = Registrasi::select('jenisKelamin', DB::raw('count(*) as total'))
            ->whereIn('user_id', $mahasiswaUserIds)
            ->whereNotNull('jenisKelamin')
            ->where('jenisKelamin', '!=', '')
            ->groupBy('jenisKelamin')
            ->pluck('total', 'jenisKelamin')
            ->toArray();
        
        $mahasiswaGenderStats = [];
        foreach ($mahasiswaGenderStatsRaw as $gender => $count) {
            $label = $this->formatGenderLabel($gender);
            $mahasiswaGenderStats[$label] = ($mahasiswaGenderStats[$label] ?? 0) + $count;
        }

        // ── Statistik Program Studi Pilihan 1 ───────────────────────────────────
        $prodiQuery1 = DB::table('users')
            ->join('program_studis', 'users.pilihan_1', '=', 'program_studis.kodeProdi')
            ->select('program_studis.namaProdi', DB::raw('COUNT(*) as total'))
            ->whereNotNull('users.pilihan_1');
        
        if ($user->role === 'dekan' && $user->fakultas_id) {
            $prodiQuery1->where('program_studis.fakultas_id', $user->fakultas_id);
        }
        
        $prodiStats = $prodiQuery1->groupBy('program_studis.namaProdi')
            ->orderByDesc('total')
            ->pluck('total', 'namaProdi');

        // ── Statistik Program Studi Pilihan 2 ───────────────────────────────────
        $prodiQuery2 = DB::table('users')
            ->join('program_studis', 'users.pilihan_2', '=', 'program_studis.kodeProdi')
            ->select('program_studis.namaProdi', DB::raw('COUNT(*) as total'))
            ->whereNotNull('users.pilihan_2');
        
        if ($user->role === 'dekan' && $user->fakultas_id) {
            $prodiQuery2->where('program_studis.fakultas_id', $user->fakultas_id);
        }
        
        $prodiStats2 = $prodiQuery2->groupBy('program_studis.namaProdi')
            ->orderByDesc('total')
            ->pluck('total', 'namaProdi');

        // ── Statistik Fakultas Pilihan 1 ────────────────────────────────────────
        $fakultasQuery1 = DB::table('users')
            ->join('program_studis', 'users.pilihan_1', '=', 'program_studis.kodeProdi')
            ->select('program_studis.fakultas', DB::raw('COUNT(*) as total'))
            ->whereNotNull('users.pilihan_1');
        
        if ($user->role === 'dekan' && $user->fakultas_id) {
            $fakultasQuery1->where('program_studis.fakultas_id', $user->fakultas_id);
        }
        
        $fakultasStats = $fakultasQuery1->groupBy('program_studis.fakultas')
            ->orderByDesc('total')
            ->pluck('total', 'fakultas');

        // ── Statistik Fakultas Pilihan 2 ────────────────────────────────────────
        $fakultasQuery2 = DB::table('users')
            ->join('program_studis', 'users.pilihan_2', '=', 'program_studis.kodeProdi')
            ->select('program_studis.fakultas', DB::raw('COUNT(*) as total'))
            ->whereNotNull('users.pilihan_2');
        
        if ($user->role === 'dekan' && $user->fakultas_id) {
            $fakultasQuery2->where('program_studis.fakultas_id', $user->fakultas_id);
        }
        
        $fakultasStats2 = $fakultasQuery2->groupBy('program_studis.fakultas')
            ->orderByDesc('total')
            ->pluck('total', 'fakultas');

        // ── Statistik Jawaban Wawancara per Pertanyaan ──────────────────────────
        $pertanyaans = PertanyaanWawancara::where('is_active', true)->get();
        $wawancaraStats = [];
        
        foreach ($pertanyaans as $pertanyaan) {
            // Ambil semua jawaban wawancara untuk pertanyaan ini
            $wawancaras = Wawancara::whereIn('user_id', $userIds)
                ->where('sudah_wawancara', true)
                ->get();
            
            $jawabanCount = [
                'a' => 0,
                'b' => 0,
                'c' => 0,
                'd' => 0
            ];
            
            foreach ($wawancaras as $wawancara) {
                $jawaban = $wawancara->jawaban;
                // Jawaban disimpan sebagai array dengan index sesuai urutan pertanyaan
                // Cari index pertanyaan ini
                $index = $pertanyaans->search(function($item) use ($pertanyaan) {
                    return $item->id === $pertanyaan->id;
                });
                
                if ($index !== false && isset($jawaban[$index])) {
                    $jawabanUser = strtolower(trim($jawaban[$index]));
                    if (in_array($jawabanUser, ['a', 'b', 'c', 'd'])) {
                        $jawabanCount[$jawabanUser]++;
                    }
                }
            }
            
            $wawancaraStats[$pertanyaan->id] = [
                'pertanyaan' => $pertanyaan->pertanyaan,
                'opsi_a' => $pertanyaan->opsi_a,
                'opsi_b' => $pertanyaan->opsi_b,
                'opsi_c' => $pertanyaan->opsi_c,
                'opsi_d' => $pertanyaan->opsi_d,
                'jawaban' => $jawabanCount,
                'total' => array_sum($jawabanCount)
            ];
        }

        return view('admin.dashboard', compact(
            'totalSoal',
            'totalUser',
            'totalAdmin',
            'totalPimpinan',
            'totalUserVerified',
            'totalUjian',
            'ujianSelesai',
            'regionStats',
            'genderStats',
            'prodiStats',
            'prodiStats2',
            'fakultasStats',
            'fakultasStats2',
            'totalPertanyaanWawancara',
            'mahasiswaPerFakultas',
            'mahasiswaPerProdi',
            'mahasiswaRegionStats',
            'mahasiswaGenderStats',
            'wawancaraStats',
            'pertanyaans',
            'isPimpinan'
        ));
    }

    private function formatCityName($cityName)
    {
        $cityName = preg_replace('/^(KOTA|KABUPATEN|KAB\.?)\s+/i', '', $cityName);
        $cityName = trim($cityName);
        if (empty($cityName)) return '';
        return ucwords(strtolower($cityName));
    }

    private function formatGenderLabel($gender)
    {
        $gender = strtoupper(trim($gender));
        $labels = [
            'L'         => 'Laki-laki',
            'LAKI-LAKI' => 'Laki-laki',
            'LAKI LAKI' => 'Laki-laki',
            'MALE'      => 'Laki-laki',
            'PRIA'      => 'Laki-laki',
            'P'         => 'Perempuan',
            'PEREMPUAN' => 'Perempuan',
            'WANITA'    => 'Perempuan',
            'FEMALE'    => 'Perempuan',
        ];
        return $labels[$gender] ?? ucfirst(strtolower($gender));
    }
}