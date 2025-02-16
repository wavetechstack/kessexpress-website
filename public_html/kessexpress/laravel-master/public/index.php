<?php

// Enable error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if storage directory is writable
if (!is_writable(__DIR__.'/../storage')) {
    die('Storage directory is not writable. Please check permissions.');
}

// Check if bootstrap/cache is writable
if (!is_writable(__DIR__.'/../bootstrap/cache')) {
    die('Bootstrap/cache directory is not writable. Please check permissions.');
}

// Check if vendor directory exists
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Vendor directory not found. Please run "composer install".');
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
*/
$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
try {
    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (Exception $e) {
    error_log($e->getMessage());
    die('Application Error: ' . $e->getMessage());
}
?>