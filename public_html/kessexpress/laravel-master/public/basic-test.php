<?php
// Force error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Basic PHP Test</h1>";

// PHP Version
echo "<h2>PHP Environment</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// File System Test
echo "<h2>File System Test</h2>";
$currentDir = __DIR__;
echo "Current Directory: " . $currentDir . "<br>";
echo "Is Readable: " . (is_readable($currentDir) ? 'Yes' : 'No') . "<br>";
echo "Is Writable: " . (is_writable($currentDir) ? 'Yes' : 'No') . "<br>";

// Basic MySQL Test
echo "<h2>MySQL Test</h2>";
try {
    $dbhost = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $dbuser = 'f281vxk316o6_laraveluser';
    $dbpass = ''; // We'll need to get this from user

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

// PHP Info (limited)
echo "<h2>PHP Configuration</h2>";
$safeIniSettings = [
    'display_errors',
    'error_reporting',
    'memory_limit',
    'upload_max_filesize',
    'post_max_size',
    'max_execution_time'
];

foreach ($safeIniSettings as $setting) {
    echo "$setting: " . ini_get($setting) . "<br>";
}
?>
