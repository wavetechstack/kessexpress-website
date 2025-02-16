<?php

// Enable error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set error log path
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../storage/logs/php-errors.log');

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if storage directory is writable
if (!is_writable(__DIR__.'/../storage')) {
    error_log('Storage directory is not writable: '.__DIR__.'/../storage');
    die('Storage directory is not writable. Please check permissions.');
}

// Check if bootstrap/cache is writable
if (!is_writable(__DIR__.'/../bootstrap/cache')) {
    error_log('Bootstrap/cache directory is not writable: '.__DIR__.'/../bootstrap/cache');
    die('Bootstrap/cache directory is not writable. Please check permissions.');
}

// Check if vendor directory exists
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    error_log('Vendor directory not found. Please run composer install.');
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
try {
    $app = require_once __DIR__.'/../bootstrap/app.php';
} catch (Exception $e) {
    error_log('Failed to load bootstrap/app.php: ' . $e->getMessage());
    die('Failed to initialize application: ' . $e->getMessage());
}

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
    error_log('Application Error: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
    die('Application Error: ' . $e->getMessage() . (env('APP_DEBUG') ? "\nStack trace: " . $e->getTraceAsString() : ''));
}
?>