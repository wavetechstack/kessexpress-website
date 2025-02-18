<?php

// Enable detailed error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Set error log path
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../storage/logs/php-errors.log');

// Check PHP version
if (version_compare(PHP_VERSION, '8.1.0', '<')) {
    die('PHP version must be at least 8.1.0. Current version: ' . PHP_VERSION);
}

define('LARAVEL_START', microtime(true));

// Verify storage directory permissions
if (!is_writable(__DIR__.'/../storage')) {
    error_log('Storage directory is not writable: '.__DIR__.'/../storage');
    die('Storage directory is not writable. Please check permissions.');
}

// Check if bootstrap/cache is writable
if (!is_writable(__DIR__.'/../bootstrap/cache')) {
    error_log('Bootstrap/cache directory is not writable: '.__DIR__.'/../bootstrap/cache');
    die('Bootstrap/cache directory is not writable. Please check permissions.');
}

// Check for composer autoloader
if (!file_exists($autoloader = __DIR__.'/../vendor/autoload.php')) {
    error_log('Composer autoloader not found. Please run composer install.');
    die('Vendor directory not found. Please run "composer install".');
}

// Load composer
require $autoloader;

try {
    // Load application
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Run the application
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Log the error
    error_log('Laravel Error: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());

    // Show error in production with limited information
    if (getenv('APP_DEBUG') === 'true') {
        die('Application Error: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
    } else {
        die('An error occurred. Please check the error logs for more information.');
    }
}

?>