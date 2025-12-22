<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Registrasi;

class AdminController extends Controller
{
    public function index()
    {
        $totalSoal = Soal::count();
        $totalUser = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalUserVerified = User::where('is_verified', true)->count();
        
        $totalUjian = Ujian::count();
        $ujianSelesai = Ujian::where('status', 'selesai')->count();

        // Statistik Asal Daerah (mengambil Kabupaten/Kota dari alamat)
        $registrations = Registrasi::select('alamat')
            ->whereNotNull('alamat')
            ->where('alamat', '!=', '')
            ->get();
        
        $regionStats = [];
        
        foreach ($registrations as $reg) {
            // Parse alamat untuk mendapatkan Kabupaten/Kota
            // Format: Jl Keterampilan, CAPPAGALUNG, BACUKIKI BARAT, KOTA PAREPARE, SULAWESI SELATAN
            $addressParts = array_map('trim', explode(',', $reg->alamat));
            
            // Langsung ambil dari posisi ke-4 (index 3) karena sudah pasti formatnya
            if (isset($addressParts[3]) && !empty(trim($addressParts[3]))) {
                $city = strtoupper(trim($addressParts[3]));
                
                // Format nama kota
                $city = $this->formatCityName($city);
                
                if (!empty($city)) {
                    if (isset($regionStats[$city])) {
                        $regionStats[$city]++;
                    } else {
                        $regionStats[$city] = 1;
                    }
                }
            }
        }
        
        // Sort berdasarkan jumlah terbanyak
        arsort($regionStats);

        // Statistik Jenis Kelamin
        $genderStatsRaw = Registrasi::select('jenisKelamin', DB::raw('count(*) as total'))
            ->whereNotNull('jenisKelamin')
            ->where('jenisKelamin', '!=', '')
            ->groupBy('jenisKelamin')
            ->pluck('total', 'jenisKelamin')
            ->toArray();
        
        // Format label jenis kelamin
        $genderStats = [];
        foreach ($genderStatsRaw as $gender => $count) {
            $label = $this->formatGenderLabel($gender);
            if (isset($genderStats[$label])) {
                $genderStats[$label] += $count;
            } else {
                $genderStats[$label] = $count;
            }
        }

        return view('admin.dashboard', compact(
            'totalSoal',
            'totalUser',
            'totalAdmin',
            'totalUserVerified',
            'totalUjian',
            'ujianSelesai',
            'regionStats',
            'genderStats'
        ));
    }

    /**
     * Format nama kota/kabupaten
     */
    private function formatCityName($cityName)
    {
        // Hapus prefix KOTA, KABUPATEN, KAB, dll
        $cityName = preg_replace('/^(KOTA|KABUPATEN|KAB\.?)\s+/i', '', $cityName);
        
        // Trim whitespace
        $cityName = trim($cityName);
        
        // Jika kosong setelah di-trim, return kosong
        if (empty($cityName)) {
            return '';
        }
        
        // Capitalize setiap kata
        $cityName = ucwords(strtolower($cityName));
        
        return $cityName;
    }

    /**
     * Format label jenis kelamin
     */
    private function formatGenderLabel($gender)
    {
        $gender = strtoupper(trim($gender));
        
        $labels = [
            'L' => 'Laki-laki',
            'LAKI-LAKI' => 'Laki-laki',
            'LAKI LAKI' => 'Laki-laki',
            'MALE' => 'Laki-laki',
            'PRIA' => 'Laki-laki',
            'P' => 'Perempuan',
            'PEREMPUAN' => 'Perempuan',
            'WANITA' => 'Perempuan',
            'FEMALE' => 'Perempuan',
        ];
        
        return $labels[$gender] ?? ucfirst(strtolower($gender));
    }
}