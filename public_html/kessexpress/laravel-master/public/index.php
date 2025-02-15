<?php

// Enable error display temporarily for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if storage directory is writable
if (!is_writable(__DIR__.'/../storage')) {
    die('Storage directory is not writable. Please check permissions.');
}

// Check if vendor directory exists
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Vendor directory not found. Please run "composer install".');
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());

?>