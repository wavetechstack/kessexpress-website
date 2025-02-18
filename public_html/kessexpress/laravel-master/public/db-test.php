<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database credentials from environment variables
    $host = getenv('PGHOST');
    $dbname = getenv('PGDATABASE');
    $username = getenv('PGUSER');
    $password = getenv('PGPASSWORD');
    $port = getenv('PGPORT');

    // Test PostgreSQL connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "PostgreSQL Connection Test Results:\n";
    echo "Connection successful!\n";
    echo "Server info: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";

    // Test query
    $result = $pdo->query("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = 'public'");
    if ($result) {
        echo "\nAvailable tables:\n";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "- " . $row['tablename'] . "\n";
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
echo "Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
?>