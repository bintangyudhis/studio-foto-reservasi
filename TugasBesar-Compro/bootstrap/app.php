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
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Tangani upload terlalu besar → redirect balik dengan pesan error yang jelas
        $exceptions->render(function (
            \Illuminate\Http\Exceptions\PostTooLargeException $e,
            \Illuminate\Http\Request $request
        ) {
            return redirect()->back()->withErrors([
                'image' => 'Ukuran file terlalu besar. Maksimal upload adalah 20MB. Silakan kompres foto terlebih dahulu.',
            ])->withInput();
        });
    })->create();
