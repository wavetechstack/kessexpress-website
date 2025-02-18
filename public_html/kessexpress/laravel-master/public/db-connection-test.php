<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Database Connection Test</h1>";

// Load environment variables from .env
$envFile = __DIR__ . '/../.env';
$envVars = parse_ini_file($envFile);

// Database configuration
$dbConfig = [
    'host' => $envVars['DB_HOST'] ?? 'localhost',
    'database' => $envVars['DB_DATABASE'] ?? 'f281vxk316o6_laravel',
    'username' => $envVars['DB_USERNAME'] ?? 'f281vxk316o6_laraveluser',
    'password' => getenv('DB_PASSWORD')
];

echo "<h2>Database Configuration:</h2>";
echo "Host: " . htmlspecialchars($dbConfig['host']) . "<br>";
echo "Database: " . htmlspecialchars($dbConfig['database']) . "<br>";
echo "Username: " . htmlspecialchars($dbConfig['username']) . "<br>";

try {
    // Test PDO Connection
    echo "<h2>Testing PDO Connection:</h2>";
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:green'>✓ PDO Connection successful!</span><br>";
    
    // Test table creation
    $pdo->exec("CREATE TABLE IF NOT EXISTS connection_test (
        id INT AUTO_INCREMENT PRIMARY KEY,
        test_column VARCHAR(255)
    )");
    echo "<span style='color:green'>✓ Test table created successfully</span><br>";
    
    // Cleanup test table
    $pdo->exec("DROP TABLE connection_test");
    echo "<span style='color:green'>✓ Test table cleaned up</span><br>";
    
} catch (PDOException $e) {
    echo "<span style='color:red'>✗ Database Error: " . htmlspecialchars($e->getMessage()) . "</span><br>";
}

// Check Laravel storage permissions
echo "<h2>Laravel Directory Permissions:</h2>";
$directories = [
    'storage' => __DIR__ . '/../storage',
    'storage/logs' => __DIR__ . '/../storage/logs',
    'storage/framework' => __DIR__ . '/../storage/framework',
    'bootstrap/cache' => __DIR__ . '/../bootstrap/cache'
];

foreach ($directories as $name => $path) {
    $exists = file_exists($path);
    $writable = is_writable($path);
    $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
    
    echo "<strong>$name:</strong><br>";
    echo "- Exists: " . ($exists ? '✓' : '✗') . "<br>";
    echo "- Writable: " . ($writable ? '✓' : '✗') . "<br>";
    echo "- Permissions: $perms<br><br>";
}

// Show PHP Configuration
echo "<h2>PHP Configuration:</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Loaded Extensions:<br>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    if (stripos($ext, 'mysql') !== false || stripos($ext, 'pdo') !== false) {
        echo "- " . htmlspecialchars($ext) . "<br>";
    }
}
?>
