<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Laravel Environment Diagnostic</h2>";

// Function to check directory permissions
function checkDirectoryPermissions($path) {
    if (!file_exists($path)) {
        return "Directory does not exist: $path";
    }
    $perms = substr(sprintf('%o', fileperms($path)), -4);
    $writable = is_writable($path);
    return [
        'path' => $path,
        'exists' => true,
        'permissions' => $perms,
        'writable' => $writable,
        'owner' => function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($path))['name'] : 'N/A',
        'group' => function_exists('posix_getgrgid') ? posix_getgrgid(filegroup($path))['name'] : 'N/A'
    ];
}

// Check critical directories
$directories = [
    'storage' => __DIR__ . '/../storage',
    'storage/app' => __DIR__ . '/../storage/app',
    'storage/framework' => __DIR__ . '/../storage/framework',
    'storage/logs' => __DIR__ . '/../storage/logs',
    'bootstrap/cache' => __DIR__ . '/../bootstrap/cache',
    'public' => __DIR__
];

echo "<h3>Directory Permissions:</h3>";
foreach ($directories as $name => $path) {
    $result = checkDirectoryPermissions($path);
    echo "<strong>$name:</strong><br>";
    echo "- Path: {$result['path']}<br>";
    echo "- Exists: " . ($result['exists'] ? 'Yes' : 'No') . "<br>";
    echo "- Permissions: {$result['permissions']}<br>";
    echo "- Writable: " . ($result['writable'] ? 'Yes' : 'No') . "<br>";
    echo "- Owner: {$result['owner']}<br>";
    echo "- Group: {$result['group']}<br><br>";
}

// Check MySQL Connection
echo "<h3>Database Connection Test:</h3>";
try {
    $db_config = parse_ini_file(__DIR__ . '/../.env');
    $host = $db_config['DB_HOST'] ?? 'localhost';
    $dbname = $db_config['DB_DATABASE'] ?? 'f281vxk316o6_laravel';
    $username = $db_config['DB_USERNAME'] ?? 'f281vxk316o6_laraveluser';
    $password = $db_config['DB_PASSWORD'] ?? '';

    echo "Testing MySQL connection with:<br>";
    echo "- Host: $host<br>";
    echo "- Database: $dbname<br>";
    echo "- Username: $username<br>";

    // Try mysqli connection
    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }
    echo "MySQL Connection: <span style='color:green'>Successful</span><br>";
    echo "MySQL Server Version: " . $mysqli->server_info . "<br>";
    $mysqli->close();
} catch (Exception $e) {
    echo "<span style='color:red'>Database Error: " . $e->getMessage() . "</span><br>";
}

// Check Laravel Error Logs
echo "<h3>Recent Laravel Error Logs:</h3>";
$error_log = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($error_log) && is_readable($error_log)) {
    $logs = array_slice(file($error_log), -10);
    echo "<pre style='background:#f5f5f5;padding:10px;'>";
    foreach ($logs as $log) {
        echo htmlspecialchars($log);
    }
    echo "</pre>";
} else {
    echo "Cannot access Laravel error log. File does not exist or is not readable.<br>";
}

// Check PHP Configuration
echo "<h3>PHP Configuration:</h3>";
$required_extensions = [
    'pdo_mysql', 'openssl', 'mbstring', 'tokenizer', 'xml',
    'ctype', 'json', 'bcmath', 'fileinfo', 'curl'
];

foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "$ext: <span style='color:" . ($loaded ? 'green' : 'red') . "'>" . 
         ($loaded ? 'Loaded' : 'Not loaded') . "</span><br>";
}

echo "<h3>PHP Version and Memory:</h3>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
echo "Upload Max Filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "Post Max Size: " . ini_get('post_max_size') . "<br>";

echo "<h3>Server Information:</h3>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";

?>