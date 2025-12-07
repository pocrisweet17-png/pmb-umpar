<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudy;

class MahasiswaDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Data progress dengan pengecekan yang benar
        $steps = [
            [
                'name' => 'Pilih Prodi',
                'key' => 'is_prodi_selected',
                'completed' => (bool) $user->is_prodi_selected,
                'route' => 'prodi.view',
                'enabled' => true, // Step pertama selalu aktif
            ],
            [
                'name' => 'Bayar Pendaftaran',
                'key' => 'is_bayar_pendaftaran',
                'completed' => (bool) $user->is_bayar_pendaftaran,
                'route' => 'bayar.index',
                'enabled' => (bool) $user->is_prodi_selected,
            ],
            [
                'name' => 'Lengkapi Data',
                'key' => 'is_data_completed',
                'completed' => (bool) $user->is_data_completed,
                'route' => 'pendaftaran.index',
                'enabled' => (bool) $user->is_bayar_pendaftaran,
            ],
            [
                'name' => 'Upload Dokumen',
                'key' => 'is_dokumen_uploaded',
                'completed' => (bool) $user->is_dokumen_uploaded,
                'route' => 'dokumen.index',
                'enabled' => (bool) $user->is_data_completed,
            ],
            [
                'name' => 'Tes',
                'key' => 'is_tes_selesai',
                'completed' => (bool) $user->is_tes_selesai,
                'route' => 'tes.index',
                'enabled' => (bool) $user->is_dokumen_uploaded,
            ],
            [
                'name' => 'Wawancara',
                'key' => 'is_wawancara_selesai',
                'completed' => (bool) $user->is_wawancara_selesai,
                'route' => 'wawancara.index',
                'enabled' => (bool) $user->is_tes_selesai,
            ],
            [
                'name' => 'Daftar Ulang',
                'key' => 'is_daftar_ulang',
                'completed' => (bool) $user->is_daftar_ulang,
                'route' => 'daftar-ulang.index',
                'enabled' => (bool) $user->is_wawancara_selesai,
            ],
            [
                'name' => 'Bayar UKT',
                'key' => 'is_ukt_paid',
                'completed' => (bool) $user->is_ukt_paid,
                'route' => 'ukt.index',
                'enabled' => (bool) $user->is_daftar_ulang,
            ],
        ];

        // Hitung progress persentase
        $completedSteps = collect($steps)->filter(fn($step) => $step['completed'])->count();
        $totalSteps = count($steps);
        $percent = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;

        // Cari step berikutnya yang harus dikerjakan
        $nextStep = collect($steps)->first(function($step) {
            return !$step['completed'] && $step['enabled'];
        });
        // Data fakultas untuk modal
        $fakultas = ProgramStudy::select('fakultas')
            ->distinct()
            ->orderBy('fakultas')
            ->get();

        return view('mahasiswa.dashboard', compact('steps', 'percent', 'nextStep', 'user', 'fakultas'));
    }
}