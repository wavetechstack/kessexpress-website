<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database credentials
    $host = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $username = 'f281vxk316o6_laraveluser';
    $password = getenv('DB_PASSWORD');
    $port = 3306;

    // Test MySQL connection
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "MySQL Connection Test Results:\n";
    echo "Connection successful!\n";
    echo "Server info: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";

    // Test query
    $result = $pdo->query("SHOW TABLES");
    if ($result) {
        echo "\nAvailable tables:\n";
        while ($row = $result->fetch(PDO::FETCH_COLUMN)) {
            echo "- " . $row . "\n";
        }
    }

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
echo "MySQL Extensions: " . implode(', ', array_filter(get_loaded_extensions(), function($ext) {
    return stripos($ext, 'mysql') !== false || stripos($ext, 'pdo') !== false;
})) . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
?>