<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StepBayarPendaftaran
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Kalau user belum bayar
        // asumsikan relasi registrasi ada: $user->registrasi
        $reg = $user->registrasi ?? null;
        if (! $reg || ! $reg->is_prodi_selected) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Silakan lakukan pembayaran pendaftaran terlebih dahulu.');
        }

        return $next($request);
    }
}
