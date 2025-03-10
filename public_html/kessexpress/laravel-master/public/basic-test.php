<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Basic PHP Test</h1>";

// Basic PHP Info
echo "<h2>PHP Environment</h2>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "<li>Script Path: " . $_SERVER['SCRIPT_FILENAME'] . "</li>";
echo "</ul>";

// File Permissions Test
echo "<h2>File System Test</h2>";
$testFile = __DIR__ . '/test-write.txt';
$writeTest = @file_put_contents($testFile, 'Test write');
echo "Write Test: " . ($writeTest !== false ? 'Success' : 'Failed') . "<br>";
if (file_exists($testFile)) {
    unlink($testFile);
}

// Server Software
echo "<h2>Server Information</h2>";
echo "<ul>";
echo "<li>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Server Name: " . $_SERVER['SERVER_NAME'] . "</li>";
echo "<li>Server Protocol: " . $_SERVER['SERVER_PROTOCOL'] . "</li>";
echo "</ul>";

// Laravel Directory Structure
echo "<h2>Laravel Directory Structure</h2>";
$baseDir = dirname(__DIR__);
$criticalDirs = [
    'storage',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($criticalDirs as $dir) {
    $path = $baseDir . '/' . $dir;
    echo "<strong>$dir:</strong><br>";
    echo "- Exists: " . (file_exists($path) ? 'Yes' : 'No') . "<br>";
    if (file_exists($path)) {
        echo "- Readable: " . (is_readable($path) ? 'Yes' : 'No') . "<br>";
        echo "- Writable: " . (is_writable($path) ? 'Yes' : 'No') . "<br>";
        echo "- Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "<br>";
    }
    echo "<br>";
}

// Try to create test files in critical directories
echo "<h2>Write Permission Test</h2>";
foreach ($criticalDirs as $dir) {
    $path = $baseDir . '/' . $dir;
    if (file_exists($path)) {
        $testFile = $path . '/test.txt';
        $result = @file_put_contents($testFile, 'Test write ' . date('Y-m-d H:i:s'));
        echo "$dir: " . ($result !== false ? '✓ Write successful' : '✗ Write failed') . "<br>";
        if (file_exists($testFile)) {
            unlink($testFile);
        }
    }
}

?>