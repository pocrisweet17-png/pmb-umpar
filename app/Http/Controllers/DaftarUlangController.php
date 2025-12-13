<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DaftarUlangController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('programStudi')
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$mahasiswa) {
                return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
            }
        // Ambil data mahasiswa berdasarkan user yang login
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        $user = Auth::user()->load('programStudiPilihan1');

        return view('daftar-ulang.index', compact('mahasiswa','user'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nim' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:pdf|max:2048', // max 2MB
            'pernyataan' => 'required|accepted',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berformat PDF',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB',
            'pernyataan.accepted' => 'Anda harus menyetujui pernyataan',
        ]);

        // Ambil data mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())
                              ->where('nim', $validated['nim'])
                              ->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak valid.');
        }

        // Cek apakah sudah pernah daftar ulang
        if ($mahasiswa->is_daftar_ulang) {
            return redirect()->back()->with('daftar_ulang_error', 'Anda sudah melakukan pendaftaran ulang sebelumnya.');
        }

        // Upload file bukti pembayaran
        $filePath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($mahasiswa->bukti_pembayaran && Storage::disk('public')->exists($mahasiswa->bukti_pembayaran)) {
                Storage::disk('public')->delete($mahasiswa->bukti_pembayaran);
            }

            $file = $request->file('bukti_pembayaran');
            $fileName = 'bukti_' . $mahasiswa->nim . '_' . time() . '.pdf';
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
        }

        // Update data mahasiswa dengan informasi daftar ulang
        $mahasiswa->update([
            'semester' => '1',
            'tahun_akademik' => '2026/2027',
            'bukti_pembayaran' => $filePath,
            'pernyataan_daftar_ulang' => true,
            'is_daftar_ulang' => true,
            'tanggal_daftar_ulang' => now(),
            'status_daftar_ulang' => 'pending'
        ]);

        // Update status di tabel registrasi jika ada
        $registrasi = Registrasi::where('user_id', Auth::id())->first();
        if ($registrasi) {
            FormulirPendaftaran::where('nomorPendaftaran', $registrasi->nomorPendaftaran)
                ->update(['is_daftar_ulang' => true]);
        }

        return redirect()->route('mahasiswa.dashboard')
                ->with('daftar_ulang_success', 'Pendaftaran ulang berhasil! Data Anda sedang diverifikasi.');
    }
}
