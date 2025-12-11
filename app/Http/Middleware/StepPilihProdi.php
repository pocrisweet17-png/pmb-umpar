<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class StepPilihProdi
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        Log::info('StepPilihProdi middleware', [
            'user_id' => $user ? $user->id : null,
            'is_prodi_selected' => $user ? $user->is_prodi_selected : null,
            'path' => $request->path(),
            'is_ajax' => $request->ajax()
        ]);
        
        if (!$user || !$user->is_prodi_selected) {
            // Jika AJAX request, return JSON
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan pilih program studi terlebih dahulu.',
                    'redirect' => route('prodi.view')
                ], 403);
            }
            
            // Jika normal request, redirect
            return redirect()->route('prodi.view')
                ->with('error', 'Silakan pilih program studi terlebih dahulu.');
        }
        
        return $next($request);
    }
}