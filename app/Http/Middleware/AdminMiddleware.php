<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'keuangan','wr-3','dekan','admisi','pimpinan'])) {

            abort(403, 'Anda tidak memiliki akses.');
        }
        return $next($request);
    }
}