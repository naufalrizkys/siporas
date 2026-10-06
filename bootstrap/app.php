<?php

use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

// Naikkan batas upload untuk form pendaftaran dengan banyak lampiran
ini_set('upload_max_filesize', '32M');
ini_set('post_max_size', '64M');
ini_set('max_file_uploads', '30');

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => EnsureIsAdmin::class,
        ]);

        // Redirect ke login jika akses halaman yang butuh auth tanpa login
        $middleware->redirectGuestsTo(function (Request $request) {
            session()->flash('warning', 'Silakan login terlebih dahulu untuk mengakses menu tersebut.');

            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
