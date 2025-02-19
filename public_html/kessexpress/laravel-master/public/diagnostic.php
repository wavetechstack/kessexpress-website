<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Basic System Diagnostic</h2>";

// Check PHP Version and Extensions
echo "<h3>1. PHP Environment:</h3>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Loaded Extensions:<br>";
echo "<ul>";
foreach (get_loaded_extensions() as $ext) {
    echo "<li>$ext</li>";
}
echo "</ul>";

// Check Critical Directories
echo "<h3>2. Directory Permissions:</h3>";
$directories = [
    '.' => 'Public Directory',
    '../storage' => 'Storage Directory',
    '../bootstrap/cache' => 'Cache Directory'
];

foreach ($directories as $dir => $label) {
    $fullPath = realpath(__DIR__ . '/' . $dir);
    echo "<strong>$label:</strong><br>";
    if ($fullPath) {
        echo "Path: " . htmlspecialchars($fullPath) . "<br>";
        echo "Exists: Yes<br>";
        echo "Readable: " . (is_readable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "Writable: " . (is_writable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";
    } else {
        echo "Path not found<br>";
    }
    echo "<br>";
}

// Check Environment File
echo "<h3>3. Environment File:</h3>";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo ".env file exists<br>";
    echo "Readable: " . (is_readable($envPath) ? 'Yes' : 'No') . "<br>";
    if (is_readable($envPath)) {
        $envContents = file_get_contents($envPath);
        $envLines = explode("\n", $envContents);
        echo "Environment Variables (names only):<br>";
        echo "<ul>";
        foreach ($envLines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, ) = explode('=', $line, 2);
                echo "<li>" . htmlspecialchars(trim($key)) . "</li>";
            }
        }
        echo "</ul>";
    }
} else {
    echo ".env file not found<br>";
}

// Basic Database Connection Test
echo "<h3>4. Database Connection Test:</h3>";
try {
    $dbhost = '127.0.0.1';
    $dbport = '3306';
    $mysqli = new mysqli($dbhost, 'test_connection');
    if ($mysqli->connect_errno) {
        echo "MySQL Server Available: Yes (but connection failed as expected)<br>";
    }
} catch (Exception $e) {
    if (strpos($e->getMessage(), "Connection refused") !== false) {
        echo "MySQL Server Available: No<br>";
    } else {
        echo "MySQL Server Available: Yes<br>";
    }
}

// Server Information
echo "<h3>5. Server Information:</h3>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Path: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

?>
