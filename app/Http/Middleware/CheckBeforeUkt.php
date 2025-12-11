<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBeforeUkt
{
    /**
     * Handle an incoming request.
     * Middleware ini untuk memastikan user bisa akses halaman pembayaran UKT
     * Syarat: Sudah bayar pendaftaran, sudah tes, dan sudah wawancara
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Cek apakah sudah bayar pendaftaran
        if (!$user->is_bayar_pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan pembayaran pendaftaran terlebih dahulu.');
        }

        // Cek apakah sudah tes
        if (!$user->is_tes_selesai) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan tes terlebih dahulu.');
        }

        // Cek apakah sudah wawancara
        if (!$user->is_wawancara_selesai) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan wawancara terlebih dahulu.');
        }

        // Cek apakah SUDAH bayar UKT (jika sudah, redirect ke dashboard)
        if ($user->is_ukt_paid) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah menyelesaikan pembayaran UKT.');
        }

        return $next($request);
    }
}