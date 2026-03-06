<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StepUploadDokumen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        // asumsikan relasi registrasi ada: $user->registrasi
        $reg = $user->registrasi ?? null;
        if (! $reg || ! $reg->	is_dokumen_uploaded) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Silakan lengkapi dokumen terlebih dahulu.');
        }

        return $next($request);
    }
}
