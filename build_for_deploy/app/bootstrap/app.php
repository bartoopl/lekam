<?php

// Suppress PHP errors globally
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('display_startup_errors', 0);

// Set PHP upload limits
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_execution_time', '300');
ini_set('memory_limit', '256M');
ini_set('max_input_time', '300');

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Get the base path for the application
$basePath = dirname(__DIR__);

return Application::configure(basePath: $basePath)
    ->withRouting(
        web: $basePath . '/routes/web.php',
        commands: $basePath . '/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Trust all proxies for Heroku
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
