<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect ke provider (Google / Facebook / Apple)
     */
    public function redirect(string $provider)
    {
        abort_unless(
            in_array($provider, ['google', 'facebook', 'apple']),
            404
        );

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Callback dari provider
     */
    public function callback(string $provider)
    {
        abort_unless(
            in_array($provider, ['google', 'facebook', 'apple']),
            404
        );

        $socialUser = Socialite::driver($provider)->user();

        $email = $socialUser->getEmail(); // bisa null (Apple)
        $providerId = $socialUser->getId();

        // 1️⃣ Cari user berdasarkan email (jika ada)
        if ($email) {
            $user = User::where('email', $email)->first();
        } else {
            // 2️⃣ Fallback: provider + provider_id
            $user = User::where('provider', $provider)
                ->where('provider_id', $providerId)
                ->first();
        }

        // 3️⃣ Jika user belum ada → buat baru
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName()
                    ?? $socialUser->getNickname()
                    ?? 'User',
                'email' => $email, // boleh null
                'provider' => $provider,
                'provider_id' => $providerId,
                'role' => 'pelanggan',
                'password' => null,
            ]);
        }

        // 4️⃣ Jika user lama tapi belum punya provider → update
        if (!$user->provider) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $providerId,
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
