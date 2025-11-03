<?php

use App\Http\Middleware\CheckRoleMiddleware;
use App\Http\Middleware\ExamSessionLifetime;
use App\Http\Middleware\RedirectIfAuthenticated;
use Dompdf\Dompdf;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Jenssegers\Agent\Facades\Agent;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'check_role' => CheckRoleMiddleware::class,
            'Agent' => Agent::class,
            'DomPDF' => Dompdf::class,
            'exam.session' => ExamSessionLifetime::class,
        ]);

        $middleware->web(append: [
            \Fahlisaputra\Minify\Middleware\MinifyHtml::class,
            \Fahlisaputra\Minify\Middleware\MinifyCss::class,
            \Fahlisaputra\Minify\Middleware\MinifyJavascript::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
