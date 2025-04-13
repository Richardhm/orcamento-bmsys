<?php

use App\Http\Middleware\ApenasAdministrador;
use App\Http\Middleware\ApenasDesenvolvedor;
use App\Http\Middleware\PreventSimultaneousLogins;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\MobileSessionFix;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'login',
            'logout',
            '/callback',
            '/callback/*'
        ]);
        $middleware->append(MobileSessionFix::class);
        $middleware->alias([
            'prevent-simultaneous-logins' => PreventSimultaneousLogins::class,
            'apenasDesenvolvedores' => ApenasDesenvolvedor::class,
            'apenasAdministradores' => ApenasAdministrador::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
