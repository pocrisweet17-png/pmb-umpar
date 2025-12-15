<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DokumentController extends Controller
{
    public function index()
    {
        return view('dokumen.upload');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'dokumen.*' => 'required|file|max:5120', // max 5MB
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Cek apakah sudah pernah upload (untuk replace)
            $existingCount = Dokumen::where('user_id', $user->id)->count();
            if ($existingCount > 0) {
                // Hapus dokumen lama
                Dokumen::where('user_id', $user->id)->delete();
                Log::info('Deleted old documents for user: ' . $user->id);
            }

            $uploadedCount = 0;

            // Mapping nama dokumen
            $jenisMapping = [
                'ijazah'   => 'Ijazah SMA/SMK/MA',
                'nilai_un' => 'Nilai Ujian Nasional',
                'akte'     => 'Akte Kelahiran',
                'kk'       => 'Kartu Keluarga',
                'foto'     => 'Pas Foto 3x4',
            ];

            // Upload setiap dokumen
            foreach ($request->file('dokumen') as $jenis => $file) {
                
                $timestamp = now()->format('YmdHis');
                $namaFile = "{$jenis}_{$user->id}_{$timestamp}." . $file->getClientOriginalExtension();
                $format   = $file->getClientOriginalExtension();

                // Store file
                $path = $file->storeAs('dokumen', $namaFile, 'public');

                // Simpan ke database
                Dokumen::create([
                    'user_id'           => $user->id,
                    'jenisDokumen'      => $jenisMapping[$jenis] ?? ucfirst($jenis),
                    'namaFile'          => $namaFile,
                    'formatFile'        => $format,
                    'urlFile'           => $path, // Simpan path relatif
                    'tanggalUpload'     => now(),
                    'statusVerifikasi'  => false,
                    'catatanVerifikasi' => null,
                ]);

                $uploadedCount++;
                
                Log::info("Document uploaded: {$jenis}", [
                    'user_id' => $user->id,
                    'file' => $namaFile
                ]);
            }

            // ✅ UPDATE STATUS DI TABEL USERS (bukan FormulirPendaftaran)
            $user->is_dokumen_uploaded = true;
            $user->save();

            DB::commit();

            Log::info('All documents uploaded successfully', [
                'user_id' => $user->id,
                'count' => $uploadedCount
            ]);

            return redirect()->route('mahasiswa.dashboard')
                ->with('success', "Berhasil mengupload {$uploadedCount} dokumen!");

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error uploading documents', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Gagal mengupload dokumen: ' . $e->getMessage())
                ->withInput();
        }
    }
}