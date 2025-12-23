<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use App\Models\Wawancara;
use App\Models\PertanyaanWawancara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WawancaraController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sudahWawancara = Wawancara::where('user_id', $user->id)->exists(); // FIX: exsists -> exists

        $wawancara = null;
        if ($sudahWawancara) {
            $wawancara = Wawancara::where('user_id', $user->id)->first();
        }
        
        // FIX: Variable name consistency
        $pertanyaans = PertanyaanWawancara::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('wawancara.index', compact('sudahWawancara', 'wawancara', 'pertanyaans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if(Wawancara::where('user_id', $user->id)->exists()){
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Anda sudah pernah mengikuti wawancara!');
        }
        
        $totalPertanyaan = PertanyaanWawancara::where('is_active', true)->count();
        $jawabanCount = count($request->jawaban ?? []);

        if ($jawabanCount < $totalPertanyaan) {
            return redirect()->back()
                ->with('error', 'Harap jawab semua pertanyaan wawancara!');
        }
        
        DB::beginTransaction();
        try {
            Wawancara::create([
                'user_id' => $user->id,
                'jawaban' => $request->jawaban,
                'tanggal_wawancara' => now(),
                'sudah_wawancara' => true,
            ]);

            // Update status is_wawancara di tabel user
            $user->update([
                'is_wawancara_selesai' => true,
            ]);
            
            DB::commit();

            return redirect()->route('mahasiswa.dashboard')
                ->with('success', 'Wawancara berhasil diselesaikan! Silakan lanjutkan ke tahap berikutnya.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } 
    }
}