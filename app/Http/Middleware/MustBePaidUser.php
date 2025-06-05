<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MustBePaidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user punya booking dengan status pembayaran PAID
        $hasPaid = $user->pembayarans()->where('midtrans_transaction_status', 'settlement')->exists();

        if (!$hasPaid) {
            return redirect('/')->with('error', 'Anda harus melakukan pembayaran terlebih dahulu untuk mengakses dashboard.');
        }

        return $next($request);
    }
}
