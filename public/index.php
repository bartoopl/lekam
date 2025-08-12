<?php

// Suppress broken pipe errors completely
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('display_startup_errors', 0);

// Suppress broken pipe errors
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_USER_NOTICE & ~E_USER_WARNING);
ini_set('display_errors', 0);
ini_set('log_errors', 0);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

// Set PHP upload limits
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_execution_time', '300');
ini_set('memory_limit', '256M');
ini_set('max_input_time', '300');

use Illuminate\Foundation\Application;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
