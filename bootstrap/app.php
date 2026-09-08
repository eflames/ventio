<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckLicense;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\UserIsActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Rutas "api" originales del proyecto: se atienden con sesión/CSRF (middleware web)
            Route::prefix('api')->middleware('web')->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));

        $middleware->redirectUsersTo('/');

        $middleware->trustProxies(at: '*');

        $middleware->trimStrings(except: [
            'password',
            'password_confirmation',
        ]);

        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'isActive' => UserIsActive::class,
            'validHash' => CheckLicense::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return response()->view('errors.exception', [
                'error' => 'Ha expirado el tiempo para enviar el formulario, actualiza e intentalo de nuevo',
            ], 419);
        });
    })->create();
