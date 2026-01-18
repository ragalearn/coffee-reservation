<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyOtpController extends Controller
{
    /**
     * Tampilkan halaman verifikasi OTP
     */
    public function index()
    {
        // Keamanan: jika sudah verifikasi, jangan masuk halaman OTP lagi
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verify-otp');
    }

    /**
     * Proses verifikasi OTP
     */
    public function verify(Request $request)
    {
        // Testing OTP (sementara)
        $validOtp = '1234';

        // Sesuaikan dengan name input di blade
        $userOtp = $request->otp_code;

        if ($userOtp === $validOtp) {
            $user = Auth::user();

            // Gunakan mekanisme standar Laravel
            $user->markEmailAsVerified();

            // Redirect ke HOME (bukan dashboard)
            return redirect()
                ->route('home')
                ->with('status', 'Email verified successfully!');
        }

        return back()->withErrors([
            'otp' => 'The provided OTP code is incorrect.',
        ]);
    }
}
