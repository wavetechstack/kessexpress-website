<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Error Log Check</h2>";

// Check storage logs
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath)) {
    echo "<h3>Recent Error Logs:</h3>";
    echo "<pre>";
    // Get last 50 lines of the log file
    $logs = file_exists($logPath) ? array_slice(file($logPath), -50) : [];
    foreach ($logs as $log) {
        if (strpos($log, 'error') !== false || strpos($log, 'Error') !== false || strpos($log, 'exception') !== false) {
            echo htmlspecialchars($log);
        }
    }
    echo "</pre>";
} else {
    echo "<p>No log file found at: " . htmlspecialchars($logPath) . "</p>";
}

// Check environment
echo "<h3>Environment Check:</h3>";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists<br>";
    // Check key environment variables (without displaying sensitive data)
    $envVars = [
        'APP_ENV' => 'Environment',
        'DB_CONNECTION' => 'Database Type',
        'DB_HOST' => 'Database Host',
        'DB_PORT' => 'Database Port',
        'DB_DATABASE' => 'Database Name',
        'DB_USERNAME' => 'Database User'
    ];
    
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $envValues = [];
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $envValues[trim($key)] = trim($value);
        }
    }
    
    foreach ($envVars as $key => $label) {
        echo "$label: " . (isset($envValues[$key]) ? "✓ Set" : "✗ Missing") . "<br>";
    }
} else {
    echo "✗ .env file missing<br>";
}

// Check storage permissions
echo "<h3>Directory Permissions:</h3>";
$directories = [
    '../storage' => 'Storage Directory',
    '../storage/logs' => 'Logs Directory',
    '../storage/framework' => 'Framework Directory',
    '../storage/framework/views' => 'Views Directory',
    '../storage/framework/cache' => 'Cache Directory',
    '../bootstrap/cache' => 'Bootstrap Cache'
];

foreach ($directories as $dir => $label) {
    $fullPath = realpath(__DIR__ . '/' . $dir);
    if ($fullPath) {
        echo "$label:<br>";
        echo "- Path: " . htmlspecialchars($fullPath) . "<br>";
        echo "- Readable: " . (is_readable($fullPath) ? '✓' : '✗') . "<br>";
        echo "- Writable: " . (is_writable($fullPath) ? '✓' : '✗') . "<br>";
        echo "- Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";
    } else {
        echo "$label: Directory not found<br>";
    }
    echo "<br>";
}

// Test database connection
echo "<h3>Database Connection Test:</h3>";
try {
    if (isset($envValues['DB_CONNECTION']) && $envValues['DB_CONNECTION'] === 'mysql') {
        $host = $envValues['DB_HOST'] ?? '127.0.0.1';
        $port = $envValues['DB_PORT'] ?? '3306';
        $database = $envValues['DB_DATABASE'] ?? '';
        $username = $envValues['DB_USERNAME'] ?? '';
        $password = $envValues['DB_PASSWORD'] ?? '';

        $mysqli = new mysqli($host, $username, $password, $database, $port);
        
        if ($mysqli->connect_error) {
            throw new Exception("MySQL Connection Error: " . $mysqli->connect_error);
        }
        
        echo "✓ MySQL Connection successful<br>";
        echo "Server version: " . $mysqli->server_info . "<br>";
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "✗ Database Error: " . htmlspecialchars($e->getMessage()) . "<br>";
}
?>
