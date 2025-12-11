<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StepBayarUkt
{
    /**
     * Handle an incoming request.
     * Middleware ini untuk memastikan user SUDAH bayar UKT
     * Digunakan untuk route SETELAH pembayaran UKT (misal: daftar ulang)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Cek apakah user SUDAH bayar UKT
        if (!$user->is_ukt_paid) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan melakukan pembayaran UKT Semester 1 terlebih dahulu.');
        }

        return $next($request);
    }
}