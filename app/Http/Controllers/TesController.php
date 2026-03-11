<?php

namespace App\Http\Controllers;

use update;
use App\Models\Ujian;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cek apakah user sudah pernah ujian
        $ujian = Ujian::where('idUser', $user->id)
                     ->whereIn('status', ['sedang_berlangsung', 'selesai'])
                     ->first();
        
        if ($ujian) {
            return redirect()->route('mahasiswa.hasil', ['idUjian' => $ujian->idUjian]);
        }
        
        return redirect()->route('mahasiswa.ujian');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $user->update(['is_tes_selesai' => true]);
        
        $registrasi = Registrasi::where('user_id', Auth::id())->first();
        if ($registrasi) {
            FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
                ->update(['is_tes_selesai' => true]);
        }

        return redirect()->route('mahasiswa.dashboard')
                        ->with('tes_success', 'Tes berhasil diselesaikan!');
    }
}