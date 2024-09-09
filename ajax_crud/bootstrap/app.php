<?php

use App\Http\Middleware\AgeCheck;
use App\Http\Middleware\CountryCheck;
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
        //
        $middleware->appendToGroup('checkone',[
            AgeCheck::class,
            CountryCheck::class
        ]);

        // other middleware group..
        // $middleware->appendToGroup('checktwo',[
        //     AgeCheck::class,
        //     CountryCheck::class
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
