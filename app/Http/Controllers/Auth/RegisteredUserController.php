<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Tambahkan 'role' => 'pelanggan' agar user baru otomatis jadi pelanggan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan', 
        ]);

        event(new Registered($user));

        Auth::login($user);

        // 2. LOGIKA REDIRECT (PENTING)
        // Cek Role User yang baru login
        if ($user->role === 'admin') {
            // Jika Admin, arahkan ke Dashboard Admin
            return redirect()->route('admin.dashboard');
        }

        // Jika Pelanggan (User Biasa), arahkan ke Home (Halaman Utama)
        // Ini akan menghilangkan error "Route [dashboard] not defined"
        return redirect('/');
    }
}