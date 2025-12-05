<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPayment
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Kalau user belum bayar
        if ($user->is_paid !== 'lunas') {
            return redirect()->route('payment.show')
                ->with('error', 'Silakan lakukan pembayaran terlebih dahulu.');
        }

        return $next($request);
    }
}
