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
        $totalUjian = Ujian::count();
        $ujianSelesai = Ujian::where('status', 'selesai')->count();

        return view('admin.dashboard', compact('totalSoal', 'totalUser', 'totalUjian', 'ujianSelesai'));
    }
}
