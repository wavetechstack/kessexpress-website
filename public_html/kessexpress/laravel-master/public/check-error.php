<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Error Log Check</h2>";

// Check storage logs
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logPath)) {
    echo "<h3>Recent Error Logs:</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; overflow-x: auto;'>";
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
    echo "<p>Attempting to create log directory...</p>";
    if (!file_exists(dirname($logPath))) {
        mkdir(dirname($logPath), 0775, true);
        echo "<p>Created log directory</p>";
    }
}

// Check environment
echo "<h3>Environment Check:</h3>";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists<br>";
    // Check key environment variables (without displaying sensitive data)
    $envVars = [
        'APP_ENV' => 'Environment',
        'APP_KEY' => 'Application Key',
        'APP_DEBUG' => 'Debug Mode',
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
        $isSet = isset($envValues[$key]);
        $value = $isSet ? $envValues[$key] : 'Not set';
        if ($key === 'APP_KEY' || $key === 'DB_PASSWORD') {
            $value = $isSet ? '✓ Set' : '✗ Missing';
        }
        echo "$label: $value<br>";
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
    '../storage/framework/sessions' => 'Sessions Directory',
    '../bootstrap/cache' => 'Bootstrap Cache'
];

foreach ($directories as $dir => $label) {
    $fullPath = realpath(__DIR__ . '/' . $dir);
    echo "<div style='margin-bottom: 10px;'>";
    echo "<strong>$label:</strong><br>";
    if ($fullPath) {
        echo "Path: " . htmlspecialchars($fullPath) . "<br>";
        echo "Readable: " . (is_readable($fullPath) ? '✓' : '✗') . "<br>";
        echo "Writable: " . (is_writable($fullPath) ? '✓' : '✗') . "<br>";
        echo "Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";

        // Try to write a test file
        $testFile = $fullPath . '/test-' . time() . '.txt';
        $writeTest = @file_put_contents($testFile, 'Test');
        echo "Write Test: " . ($writeTest !== false ? '✓' : '✗') . "<br>";
        if (file_exists($testFile)) {
            unlink($testFile);
        }
    } else {
        echo "Directory not found - Creating...<br>";
        mkdir(__DIR__ . '/' . $dir, 0775, true);
        echo "Directory created with permissions 775<br>";
    }
    echo "</div>";
}

// Database connection test
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
    echo "<div style='background: #fff3f3; padding: 10px; margin-top: 10px;'>";
    echo "<strong>Troubleshooting Steps:</strong><br>";
    echo "1. Verify database credentials in .env file<br>";
    echo "2. Ensure MySQL server is running<br>";
    echo "3. Check if database user has proper permissions<br>";
    echo "4. Verify database exists and is accessible<br>";
    echo "</div>";
}

// PHP Configuration
echo "<h3>PHP Configuration:</h3>";
echo "<ul>";
foreach (['upload_max_filesize', 'post_max_size', 'memory_limit', 'max_execution_time'] as $setting) {
    echo "<li>$setting: " . ini_get($setting) . "</li>";
}
echo "</ul>";

?>