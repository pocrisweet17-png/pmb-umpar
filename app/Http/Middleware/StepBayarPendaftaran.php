<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class StepBayarPendaftaran
{

    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'keuangan',])) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        return $next($request);
    
            $user = $request->user();
        
        Log::info('StepBayarPendaftaran check', [
            'user_id' => $user->id,
            'is_prodi_selected' => $user->is_prodi_selected
        ]);
        
        if (!$user->is_prodi_selected) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }
        
        return $next($request);

    }
}