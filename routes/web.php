<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
// Tambahkan Controller User Admin
use App\Http\Controllers\Admin\UserController as AdminUserController; 
use App\Http\Controllers\Pelanggan\ReservationController as PelangganReservationController;
use App\Http\Controllers\Pelanggan\CategoryController as PelangganCategoryController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [VerifyOtpController::class, 'index'])->name('otp.view');
    Route::post('/verify-otp', [VerifyOtpController::class, 'verify'])->name('otp.submit');
});

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'otp_verified'])->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| SOCIAL LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/auth/{provider}', [SocialLoginController::class, 'redirect'])
    ->where('provider', 'google|facebook|apple')
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->where('provider', 'google|facebook|apple')
    ->name('social.callback');

/*
|--------------------------------------------------------------------------
| AUTH + OTP VERIFIED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp_verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            // Manajemen Kategori
            Route::resource('categories', CategoryController::class);

            // Manajemen User (BARU DITAMBAHKAN)
            Route::get('/users', [AdminUserController::class, 'index'])
                ->name('users.index');

            // Manajemen Reservasi
            Route::get('/reservations', [AdminReservationController::class, 'index'])
                ->name('reservations.index');

            Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])
                ->name('reservations.show');

            Route::patch('/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])
                ->name('reservations.confirm');

            Route::patch('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])
                ->name('reservations.reject');
        });

    /*
    |--------------------------------------------------------------------------
    | PELANGGAN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/categories', [PelangganCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [PelangganCategoryController::class, 'show'])->name('categories.show');
        Route::get('reservations/create', [PelangganReservationController::class, 'create'])->name('reservations.create');
        Route::post('reservations/review', [PelangganReservationController::class, 'review'])->name('reservations.review');
        Route::post('reservations/store', [PelangganReservationController::class, 'store'])->name('reservations.store');
        Route::get('reservations', [PelangganReservationController::class, 'index'])->name('reservations.index');
        Route::delete('reservations/{reservation}', [PelangganReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';