<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;
        
        // Debug: Log untuk melihat role yang dikirim
        \Log::info('Role Middleware - User Role: ' . $userRole);
        \Log::info('Role Middleware - Allowed Roles: ', $roles);
        
        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (empty($roles)) {
            abort(403, 'No role specified for this route.');
        }
        
        if (!in_array($userRole, $roles)) {
            abort(403, "Unauthorized access. Your role: {$userRole}. Required roles: " . implode(', ', $roles));
        }

        return $next($request);
    }
}

