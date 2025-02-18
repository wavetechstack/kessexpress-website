<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Environment Test</h1>";

// Basic PHP Info
echo "<h2>PHP Environment</h2>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "</ul>";

// File System Permissions
echo "<h2>File System Permissions</h2>";
$criticalPaths = [
    '../storage' => 'Storage Directory',
    '../storage/logs' => 'Logs Directory',
    '../storage/framework' => 'Framework Directory',
    '../bootstrap/cache' => 'Cache Directory',
    '.' => 'Public Directory'
];

echo "<ul>";
foreach ($criticalPaths as $path => $description) {
    $fullPath = realpath(__DIR__ . '/' . $path);
    if ($fullPath) {
        echo "<li>$description ($path):<br>";
        echo "- Exists: Yes<br>";
        echo "- Readable: " . (is_readable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "- Writable: " . (is_writable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "- Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";
        echo "</li>";
    } else {
        echo "<li>$description ($path): Not Found</li>";
    }
}
echo "</ul>";

// Environment Configuration
echo "<h2>Environment Configuration</h2>";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists<br>";
    if (is_readable($envFile)) {
        echo "✓ .env file is readable<br>";
    } else {
        echo "⚠ Warning: .env file is not readable<br>";
    }
} else {
    echo "⚠ Warning: .env file not found<br>";
}

// PHP Extensions
echo "<h2>Required PHP Extensions</h2>";
$requiredExtensions = [
    'pdo_mysql' => 'PDO MySQL',
    'openssl' => 'OpenSSL',
    'mbstring' => 'Multibyte String',
    'tokenizer' => 'Tokenizer',
    'xml' => 'XML',
    'ctype' => 'Ctype',
    'json' => 'JSON',
    'bcmath' => 'BCMath',
    'fileinfo' => 'FileInfo'
];

echo "<ul>";
foreach ($requiredExtensions as $ext => $name) {
    $loaded = extension_loaded($ext);
    echo "<li style='color: " . ($loaded ? 'green' : 'red') . "'>";
    echo "$name: " . ($loaded ? '✓' : '✗');
    echo "</li>";
}
echo "</ul>";

// Basic MySQL Test
echo "<h2>MySQL Test</h2>";
try {
    $dbhost = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $dbuser = 'f281vxk316o6_laraveluser';
    $dbpass = getenv('DB_PASSWORD');

    $mysqli = @new mysqli($dbhost, $dbuser, $dbpass);
    if ($mysqli->connect_error) {
        echo "MySQL Connect Error: " . $mysqli->connect_error;
    } else {
        echo "MySQL Connection: Success<br>";
        echo "MySQL Version: " . $mysqli->server_info;
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "MySQL Error: " . $e->getMessage();
}

// PHP Configuration Values
echo "<h2>PHP Configuration</h2>";
$importantSettings = [
    'upload_max_filesize' => 'Upload Max Filesize',
    'post_max_size' => 'Post Max Size',
    'memory_limit' => 'Memory Limit',
    'max_execution_time' => 'Max Execution Time',
    'display_errors' => 'Display Errors'
];

echo "<ul>";
foreach ($importantSettings as $setting => $label) {
    echo "<li>$label: " . ini_get($setting) . "</li>";
}
echo "</ul>";
?>