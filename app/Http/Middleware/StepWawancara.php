<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StepWawancara
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            // Jika AJAX, return JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.'
                ], 401);
            }
            return redirect()->route('login');
        }

        if (!$user->is_wawancara_selesai) {
            // Jika AJAX, return JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan selesaikan wawancara terlebih dahulu.'
                ], 403);
            }
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Silakan selesaikan wawancara terlebih dahulu.');
        }

        return $next($request);
    }
}