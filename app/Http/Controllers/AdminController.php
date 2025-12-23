<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\PertanyaanWawancara;

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
        $totalPertanyaanWawancara = PertanyaanWawancara::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalSoal',
            'totalUser',
            'totalAdmin',
            'totalUserVerified',
            'totalUjian',
            'ujianSelesai',
            'totalPertanyaanWawancara'
        ));
    }
}
