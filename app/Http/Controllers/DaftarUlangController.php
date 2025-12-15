<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormulirPendaftaran;
use App\Models\Registrasi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DaftarUlangController extends Controller
{
    public function index()
{
    $user = Auth::user();
    
    // Cek status pembayaran UKT dari tabel users
    if (!$user->is_ukt_paid) {
        return redirect()->route('bayar.ukt')
            ->with('error', 'Silakan selesaikan pembayaran UKT terlebih dahulu.');
    }

    // Cek apakah sudah punya data mahasiswa (sudah daftar ulang)
    $mahasiswa = Mahasiswa::with('programStudi')
        ->where('user_id', $user->id)
        ->first();

    // Load relasi program studi pilihan
    $user->load('programStudiPilihan1');

    return view('daftar-ulang.index', compact('mahasiswa', 'user'));
}
    public function store(Request $request)
{
    Log::info('========== DAFTAR ULANG STORE CALLED ==========');
    Log::info('Request data:', $request->all());
    
    $user = Auth::user();
    Log::info('User ID: ' . $user->id);
    
    try {
        $validated = $request->validate([
            'nim' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:pdf|max:2048',
            'pernyataan' => 'required|accepted',
        ]);
        
        Log::info('Validation passed');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed:', $e->errors());
        return redirect()->back()->withErrors($e->errors())->withInput();
    }

    $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
    Log::info('Mahasiswa check:', ['exists' => $mahasiswa ? true : false]);
    
    if ($mahasiswa && $mahasiswa->is_daftar_ulang) {
        Log::warning('Already registered');
        return redirect()->back()->with('error', 'Sudah daftar ulang');
    }

    // Upload file
    $filePath = null;
    if ($request->hasFile('bukti_pembayaran')) {
        Log::info('File detected');
        try {
            $file = $request->file('bukti_pembayaran');
            $fileName = 'bukti_' . $validated['nim'] . '_' . time() . '.pdf';
            $filePath = $file->storeAs('bukti-pembayaran', $fileName, 'public');
            Log::info('File uploaded:', ['path' => $filePath]);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    } else {
        Log::error('No file in request');
    }

    try {
        if (!$mahasiswa) {
            Log::info('Creating new mahasiswa');
            
            $dataCreate = [
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'namaLengkap' => $user->nama_lengkap ?? $user->username,
                'kodeProdi' => $user->pilihan_1,
                'angkatan' => date('Y'),
                'statusMahasiswa' => 'aktif',
                'semester' => '1',
                'tahun_akademik' => '2026/2027',
                'bukti_pembayaran' => $filePath,
                'pernyataan_daftar_ulang' => true,
                'is_daftar_ulang' => true,
                'tanggalDaftar' => now(),
                'tanggal_daftar_ulang' => now(),
                'status_daftar_ulang' => 'pending',
            ];
            
            Log::info('Data to create:', $dataCreate);
            
            $mahasiswa = Mahasiswa::create($dataCreate);
            
            Log::info('Mahasiswa created:', ['id' => $mahasiswa->id]);
            
        } else {
            Log::info('Updating mahasiswa');
            
            $mahasiswa->update([
                'nim' => $validated['nim'],
                'semester' => '1',
                'tahun_akademik' => '2026/2027',
                'bukti_pembayaran' => $filePath,
                'pernyataan_daftar_ulang' => true,
                'is_daftar_ulang' => true,
                'tanggal_daftar_ulang' => now(),
                'status_daftar_ulang' => 'pending'
            ]);
            
            Log::info('Mahasiswa updated');
        }
        $user->is_daftar_ulang = true;
        $user->save();
        Log::info('User is_daftar_ulang updated to TRUE', ['user_id' => $user->id]);
        
        Log::info('========== DAFTAR ULANG SUCCESS ==========');
        
        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Pendaftaran ulang berhasil!');
            
    } catch (\Exception $e) {
        Log::error('========== DAFTAR ULANG ERROR ==========');
        Log::error('Error message: ' . $e->getMessage());
        Log::error('Error trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}
}
