<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ścieżka do katalogu nadrzędnego (poza public_html)
require __DIR__.'/../app/vendor/autoload.php';
$app = require_once __DIR__.'/../app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
