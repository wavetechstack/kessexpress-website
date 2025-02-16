<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test MySQL Connection
try {
    $host = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $username = 'f281vxk316o6_laraveluser';
    $password = getenv('DB_PASSWORD');

    // Try with mysqli
    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        throw new Exception("mysqli connection failed: " . $mysqli->connect_error);
    }
    echo "mysqli connection successful!\n";
    $mysqli->close();

    // Try with PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "PDO connection successful!\n";
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}

$storage_path = __DIR__.'/../storage';
$cache_path = __DIR__.'/../bootstrap/cache';
$vendor_path = __DIR__.'/../vendor';

echo "\nEnvironment Check:\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Storage writable: " . (is_writable($storage_path) ? 'Yes' : 'No') . "\n";
echo "Cache writable: " . (is_writable($cache_path) ? 'Yes' : 'No') . "\n";
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