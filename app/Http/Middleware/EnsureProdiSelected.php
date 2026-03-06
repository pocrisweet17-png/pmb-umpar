<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProdiSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = request()->user();

    if (! $user->is_prodi_selected) {
        return redirect()->route('prodi.select')
            ->with('warning', 'Silakan pilih 2 program studi terlebih dahulu.');
    }
        return $next($request);
    }
}
