<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Environment Test</h2>";

// Test Storage Permissions
$storage_path = __DIR__ . '/../storage';
$cache_path = __DIR__ . '/../bootstrap/cache';

echo "<h3>Directory Permissions:</h3>";
echo "Storage path: " . $storage_path . "<br>";
echo "Storage writable: " . (is_writable($storage_path) ? 'Yes' : 'No') . "<br>";
echo "Cache path: " . $cache_path . "<br>";
echo "Cache writable: " . (is_writable($cache_path) ? 'Yes' : 'No') . "<br>";

// Test Database Connection
echo "<h3>Database Connection Test:</h3>";
try {
    $dbhost = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $dbuser = 'f281vxk316o6_laraveluser';
    $dbpass = getenv('DB_PASSWORD');

    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!<br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}

// Check PHP Extensions
echo "<h3>Required Extensions:</h3>";
$required_extensions = [
    'pdo_mysql',
    'openssl',
    'mbstring',
    'tokenizer',
    'xml',
    'ctype',
    'json',
    'bcmath',
    'fileinfo'
];

foreach($required_extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? 'Loaded' : 'Not loaded') . "<br>";
}

// Environment Variables
echo "<h3>Environment Variables:</h3>";
$env_file = __DIR__ . '/../.env';
echo ".env file exists: " . (file_exists($env_file) ? 'Yes' : 'No') . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";


// Retained from original code:  Environment check and test file writing.  These provide additional debugging information.
echo "\nEnvironment Check:\n";
echo "PHP Version: " . PHP_VERSION . "\n";
$vendor_path = __DIR__.'/../vendor';
echo "Vendor exists: " . (file_exists($vendor_path) ? 'Yes' : 'No') . "\n";

// Test file writing
try {
    $test_file = $storage_path . '/logs/test.log';
    file_put_contents($test_file, date('Y-m-d H:i:s') . " Test log entry\n", FILE_APPEND);
    echo "Log write test: Success\n";
} catch (Exception $e) {
    echo "Log write test: Failed - " . $e->getMessage() . "\n";
}

if (function_exists('mysqli_get_client_info')) {
    echo "MySQL Client Info: " . mysqli_get_client_info() . "\n";
}

phpinfo();
?>