<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;

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

        return view('admin.dashboard', compact(
            'totalSoal',
            'totalUser',
            'totalAdmin',
            'totalUserVerified',
            'totalUjian',
            'ujianSelesai'
        ));
    }

    public function dashboard()
    {
        // Statistik Asal Daerah (mengambil Kabupaten/Kota dari alamat)
        $registrations = Registrasi::select('alamat')->whereNotNull('alamat')->get();
        
        $regionStats = [];
        foreach ($registrations as $reg) {
            // Parse alamat untuk mendapatkan Kabupaten/Kota
            // Format: Jl Keterampilan, CAPPAGALUNG, BACUKIKI BARAT, KOTA PAREPARE, SULAWESI SELATAN
            $addressParts = array_map('trim', explode(',', $reg->alamat));
            
            // Kabupaten/Kota biasanya di posisi ke-4 (index 3) dari array
            if (isset($addressParts[3])) {
                $city = strtoupper(trim($addressParts[3]));
                
                // Bersihkan dan format nama kota
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
        $genderStats = Registrasi::select('jenisKelamin', DB::raw('count(*) as total'))
            ->whereNotNull('jenisKelamin')
            ->groupBy('jenisKelamin')
            ->pluck('total', 'jenisKelamin')
            ->toArray();
        
        // Format label jenis kelamin
        $formattedGenderStats = [];
        foreach ($genderStats as $gender => $count) {
            $label = $this->formatGenderLabel($gender);
            $formattedGenderStats[$label] = $count;
        }

        return view('admin.dashboard', [
            'totalSoal',
            'totalUser', 
            'totalAdmin',
            'regionStats',
            'genderStats' => $formattedGenderStats
        ]);
    }

    /**
     * Format nama kota/kabupaten
     */
    private function formatCityName($cityName)
    {
        // Hapus prefix KOTA, KABUPATEN, KAB, dll
        $cityName = preg_replace('/^(KOTA|KABUPATEN|KAB\.?)\s+/i', '', $cityName);
        
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
            'P' => 'Perempuan',
            'PEREMPUAN' => 'Perempuan',
            'WANITA' => 'Perempuan',
            'FEMALE' => 'Perempuan',
        ];
        
        return $labels[$gender] ?? ucfirst(strtolower($gender));
    }
}
