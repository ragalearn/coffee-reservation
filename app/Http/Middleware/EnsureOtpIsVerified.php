<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // 1. BYPASS ADMIN
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // 2. CEK VERIFIKASI OTP (Gunakan kolom otp_verified_at)
        if ($user && is_null($user->otp_verified_at)) {
            
            // Izinkan akses jika sudah di rute OTP atau mau logout
            if (
                $request->routeIs('otp.view') || 
                $request->routeIs('otp.submit') || 
                $request->is('logout')
            ) {
                return $next($request);
            }

            // Jika belum verifikasi OTP, lempar ke halaman OTP
            return redirect()->route('otp.view');
        }

        return $next($request);
    }
}