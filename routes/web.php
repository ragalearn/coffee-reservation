<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerifyOtpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Pelanggan\ReservationController as PelangganReservationController;
use App\Http\Controllers\Pelanggan\CategoryController as PelangganCategoryController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }
    return view('landing');
})->name('landing');

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
| OTP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [VerifyOtpController::class, 'index'])->name('otp.view');
    Route::post('/verify-otp', [VerifyOtpController::class, 'verify'])->name('otp.submit');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

        // ================= RESERVATIONS =================
        Route::get('/reservations', [AdminReservationController::class, 'index'])
            ->name('reservations.index');

        Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])
            ->name('reservations.show');

        Route::patch('/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])
            ->name('reservations.confirm');

        Route::patch('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])
            ->name('reservations.reject');

        Route::patch('/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])
            ->name('reservations.cancel');

        // 🔥 DELETE RESERVATION
        Route::delete('/reservations/{reservation}', [AdminReservationController::class, 'destroy'])
            ->name('reservations.destroy');

        // ================= REPORTS =================
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');

        // ================= SETTINGS =================
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });

/*
|--------------------------------------------------------------------------
| PELANGGAN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'otp_verified', 'role:pelanggan'])->group(function () {

    Route::get('/home', fn () => view('home'))->name('home');

    Route::get('/categories', [PelangganCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [PelangganCategoryController::class, 'show'])->name('categories.show');

    Route::get('/reservations', [PelangganReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [PelangganReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/review', [PelangganReservationController::class, 'review'])->name('reservations.review');
    Route::post('/reservations/store', [PelangganReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [PelangganReservationController::class, 'destroy'])
        ->name('reservations.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
