<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$storage_path = __DIR__.'/../storage';
$cache_path = __DIR__.'/../bootstrap/cache';
$vendor_path = __DIR__.'/../vendor';

echo "Environment Check:\n";
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

phpinfo();
?>
