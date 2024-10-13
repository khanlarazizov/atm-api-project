<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'account_owner' => 'App\Http\Middleware\EnsureAccountOwnership',
            'delete_own_transaction' => 'App\Http\Middleware\DeleteOwnTransaction',
            'admin' => 'App\Http\Middleware\IsAdmin',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
