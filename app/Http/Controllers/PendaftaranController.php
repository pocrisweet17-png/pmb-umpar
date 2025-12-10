<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran
     */
    public function index()
    {
        $user = Auth::user();

        $registrasi = Registrasi::where('user_id', $user->id)->first();

        return view('pendaftaran.index', compact('user', 'registrasi'));
    }

    /**
     * Simpan data registrasi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenisKelamin'  => 'required|string|in:Laki-laki,Perempuan',
            'tempatLahir'   => 'required|string|max:100',
            'tanggalLahir'  => 'required|date|before:today',
            'agama'         => 'required|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat'        => 'required|string|max:500',
            'asalSekolah'   => 'required|string|max:200',
            'jurusan'       => 'required|string|max:100',
            'tahunLulus'    => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            $existingRegistrasi = Registrasi::where('user_id', $user->id)->first();

            if ($existingRegistrasi) {
                // UPDATE data
                $existingRegistrasi->update($validated);
                $registrasi = $existingRegistrasi;
                $message = 'Data pribadi berhasil diperbarui.';
            } else {
                // CREATE data baru
                $registrasi = Registrasi::create([
                    'user_id'              => $user->id,
                    'nomorPendaftaran'     => $user->nomor_registrasi,
                    'programStudiPilihan'  => $user->pilihan_1 ?? null,
                    'tanggalDaftar'        => now(),
                    'statusRegistrasi'     => 'pending',

                    'jenisKelamin'         => $validated['jenisKelamin'],
                    'tempatLahir'          => $validated['tempatLahir'],
                    'tanggalLahir'         => $validated['tanggalLahir'],
                    'agama'                => $validated['agama'],
                    'alamat'               => $validated['alamat'],
                    'asalSekolah'          => $validated['asalSekolah'],
                    'jurusan'              => $validated['jurusan'],
                    'tahunLulus'           => $validated['tahunLulus'],
                ]);

                $message = 'Data pribadi berhasil disimpan.';
            }

            // UPDATE status step pada users
            $user = User::find($registrasi->user_id);
            $user->is_data_completed = true;
            $user->save();

            DB::commit();

            Log::info('Registrasi berhasil disimpan', [
                'user_id' => $user->id,
                'data' => $validated
            ]);

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saving registrasi', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update data registrasi
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenisKelamin'  => 'required|string|in:Laki-laki,Perempuan',
            'tempatLahir'   => 'required|string|max:100',
            'tanggalLahir'  => 'required|date|before:today',
            'agama'         => 'required|string',
            'alamat'        => 'required|string|max:500',
            'asalSekolah'   => 'required|string|max:200',
            'jurusan'       => 'required|string|max:100',
            'tahunLulus'    => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        try {
            $registrasi = Registrasi::where('user_id', Auth::id())
                ->where('idRegistrasi', $id)
                ->firstOrFail();

            $registrasi->update($validated);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating registrasi', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memperbarui data.')
                ->withInput();
        }
    }
}
