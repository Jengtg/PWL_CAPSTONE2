<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // DAFTARKAN ALIAS MIDDLEWARE ANDA DI SINI
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            // Anda bisa menambahkan alias lain di sini jika perlu, misalnya:
            // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            // 'can' => \Illuminate\Auth\Middleware\Authorize::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Contoh jika Anda punya custom guest middleware
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Jika menggunakan verifikasi email Breeze
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();