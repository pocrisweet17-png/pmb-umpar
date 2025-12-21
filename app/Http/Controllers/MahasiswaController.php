<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Exports\MahasiswaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang sudah daftar ulang
     */
    public function daftarUlang()
    {
        $mahasiswas = Mahasiswa::with(['user', 'programStudi', 'registrasi'])
            ->where('is_daftar_ulang', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistik
        $stats = [
            'total' => Mahasiswa::where('is_daftar_ulang', true)->count(),
            'verified' => Mahasiswa::where('status_daftar_ulang', 'verified')->count(),
            'pending' => Mahasiswa::where('status_daftar_ulang', 'pending')->count(),
            'rejected' => Mahasiswa::where('status_daftar_ulang', 'rejected')->count(),
        ];

        return view('admin.Mahasiswa.data-mahasiswa', compact('mahasiswas', 'stats'));
    }

    /**
     * Export data mahasiswa ke Excel
     */
    public function exportExcel(Request $request)
    {
        $status = $request->get('status', 'all');
        $fileName = 'Data_Mahasiswa_Daftar_Ulang_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new MahasiswaExport($status), $fileName);
    }

    /**
     * Verifikasi daftar ulang mahasiswa
     */
    public function verifyDaftarUlang($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        $mahasiswa->update([
            'status_daftar_ulang' => 'verified',
            'statusMahasiswa' => 'aktif'
        ]);

        // Update status user juga
        $mahasiswa->user->update([
            'is_daftar_ulang' => true
        ]);

        return redirect()->back()->with('success', 'Daftar ulang berhasil diverifikasi!');
    }

    /**
     * Tolak daftar ulang mahasiswa
     */
    public function rejectDaftarUlang(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        $mahasiswa->update([
            'status_daftar_ulang' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Daftar ulang ditolak!');
    }
}