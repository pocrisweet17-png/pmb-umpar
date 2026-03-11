<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFakultasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Jika user belum login, skip middleware
        if (!$user) {
            return $next($request);
        }
        
        // Jika dekan, pastikan sudah ditugaskan ke fakultas
        if ($user->role === 'dekan' && !$user->fakultas_id) {
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Anda belum ditugaskan ke fakultas manapun. Silakan hubungi administrator untuk penugasan fakultas.');
        }
        
        return $next($request);
    }
}