<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class StepBayarPendaftaran
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        \Log::info('StepBayarPendaftaran check', [
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