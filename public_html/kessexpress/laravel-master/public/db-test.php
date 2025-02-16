<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database credentials
    $host = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $username = 'f281vxk316o6_laraveluser';
    $password = getenv('DB_PASSWORD');

    // Test MySQL connection
    $mysqli = new mysqli($host, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "MySQL Connection Test Results:\n";
    echo "Connection successful!\n";
    echo "Server info: " . $mysqli->server_info . "\n";
    echo "Host info: " . $mysqli->host_info . "\n";
    
    // Test query
    $result = $mysqli->query("SHOW TABLES");
    if ($result) {
        echo "\nAvailable tables:\n";
        while ($row = $result->fetch_array()) {
            echo "- " . $row[0] . "\n";
        }
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Directory permissions test
echo "\n\nDirectory Permissions Test:\n";
$base_path = __DIR__ . '/..';
$directories = [
    'storage' => $base_path . '/storage',
    'storage/logs' => $base_path . '/storage/logs',
    'storage/framework' => $base_path . '/storage/framework',
    'bootstrap/cache' => $base_path . '/bootstrap/cache',
];

foreach ($directories as $name => $path) {
    echo "$name:\n";
    echo "- Exists: " . (file_exists($path) ? 'Yes' : 'No') . "\n";
    echo "- Readable: " . (is_readable($path) ? 'Yes' : 'No') . "\n";
    echo "- Writable: " . (is_writable($path) ? 'Yes' : 'No') . "\n";
    echo "- Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "\n";
}

// Environment information
echo "\nPHP Environment:\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
?>
