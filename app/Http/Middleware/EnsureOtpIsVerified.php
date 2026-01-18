<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // --- MODE DARURAT / BYPASS ---
        // Biarkan semua request lewat tanpa pengecekan.
        // Nanti kalau pikiran sudah jernih, baru kita aktifkan lagi.
        
        return $next($request);
    }
}