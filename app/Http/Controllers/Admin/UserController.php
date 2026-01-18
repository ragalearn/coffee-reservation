<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan daftar user (role pelanggan)
        $users = User::where('role', 'pelanggan')->latest()->get();
        return view('admin.users.index', compact('users'));
    }
}