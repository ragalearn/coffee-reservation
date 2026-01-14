<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Pelanggan\ReservationController as PelangganReservationController;

/*
|--------------------------------------------------------------------------
| DEFAULT DASHBOARD REDIRECT (PALING ATAS)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/reservations');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH & ROLE PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('categories', CategoryController::class);
            Route::resource('tables', TableController::class);

            // 📋 List reservasi (filter)
            Route::get('/reservations', [AdminReservationController::class, 'index'])
                ->name('reservations.index');

            // 👁 Detail reservasi
            Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])
                ->name('reservations.show');

            // ✅ Konfirmasi reservasi
            Route::patch('/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])
                ->name('reservations.confirm');

            // ❌ Tolak reservasi
            Route::patch('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])
                ->name('reservations.reject');
        });

    /*
    |--------------------------------------------------------------------------
    | PELANGGAN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:pelanggan')->group(function () {

        Route::resource('reservations', PelangganReservationController::class)
            ->only(['index', 'create', 'store', 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE ROUTES
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
