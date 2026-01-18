<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | REGISTER ROUTE MIDDLEWARE
        |--------------------------------------------------------------------------
        */
        $middleware->alias([
            'role'         => \App\Http\Middleware\RoleMiddleware::class,
            'otp_verified' => \App\Http\Middleware\EnsureOtpIsVerified::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTH REDIRECT PROTECTION
        |--------------------------------------------------------------------------
        | - Guest → /login
        | - User login akses /login atau /register → /home
        */
        $middleware->redirectTo(
            guests: '/login',
            users: '/home'
        );

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
