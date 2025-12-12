<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StepLengkapiData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Cek step 1: Prodi
        if (!$user || !$user->is_prodi_selected) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        // Cek step 2: Bayar
        if (!$user->is_bayar_pendaftaran) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan pembayaran pendaftaran terlebih dahulu.');
        }

        // Cek step 3: Data Lengkap
        if (!$user->is_data_completed) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan lengkapi data diri terlebih dahulu.');
        }

        return $next($request);
    }
}
