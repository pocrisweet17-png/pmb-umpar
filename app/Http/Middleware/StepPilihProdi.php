<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StepPilihProdi
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        // asumsikan relasi registrasi ada: $user->registrasi
        $reg = $user->registrasi ?? null;
        if (! $reg || ! $reg->is_prodi_selected) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }

        return $next($request);
    }
}
