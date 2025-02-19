<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function recursiveChmod($path, $dirPermissions, $filePermissions) {
    if (!file_exists($path)) {
        mkdir($path, $dirPermissions, true);
        echo "Created directory: $path<br>";
    }

    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        if ($item->isDot()) continue;

        $itemPath = $item->getPathname();

        if ($item->isDir()) {
            chmod($itemPath, $dirPermissions);
            echo "Set directory permissions for: $itemPath<br>";
            recursiveChmod($itemPath, $dirPermissions, $filePermissions);
        } else {
            chmod($itemPath, $filePermissions);
            echo "Set file permissions for: $itemPath<br>";
        }
    }
}

$baseDir = __DIR__ . '/..';
$storagePath = $baseDir . '/storage';
$bootstrapPath = $baseDir . '/bootstrap/cache';

// Create required storage directories
$storageSubdirs = [
    '/app',
    '/app/public',
    '/framework',
    '/framework/cache',
    '/framework/sessions',
    '/framework/views',
    '/logs'
];

echo "<h1>Laravel Permissions Fix</h1>";
echo "<div style='font-family: monospace; background: #f5f5f5; padding: 20px; margin: 20px 0;'>";

foreach ($storageSubdirs as $dir) {
    $fullPath = $storagePath . $dir;
    if (!file_exists($fullPath)) {
        mkdir($fullPath, 0775, true);
        echo "Created directory: $fullPath<br>";
    }
}

// Set permissions
recursiveChmod($storagePath, 0775, 0664);
recursiveChmod($bootstrapPath, 0775, 0664);

// Create .gitignore files to prevent committing cache
$gitignoreContent = "*\n!.gitignore\n";
file_put_contents($storagePath . '/framework/cache/.gitignore', $gitignoreContent);
file_put_contents($bootstrapPath . '/.gitignore', $gitignoreContent);

echo "<br>Permissions update completed.<br>";
echo "Storage path: $storagePath<br>";
echo "Bootstrap cache path: $bootstrapPath<br>";

// Create a test file to verify write permissions
try {
    $testFile = $storagePath . '/logs/test.log';
    file_put_contents($testFile, date('Y-m-d H:i:s') . " - Permission test successful\n");
    echo "<br>✓ Successfully wrote to test log file<br>";
} catch (Exception $e) {
    echo "<br>✗ Failed to write test file: " . $e->getMessage() . "<br>";
}
echo "</div>";

echo "<div style='background: #e8f5e9; padding: 20px; margin: 20px 0; border-radius: 4px;'>";
echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Verify that all directories show '775' permissions</li>";
echo "<li>Check if the test log file was created successfully</li>";
echo "<li>Clear Laravel cache by accessing: <a href='artisan-cache-clear.php'>artisan-cache-clear.php</a></li>";
echo "<li>Try accessing your Laravel application again</li>";
echo "</ol>";
echo "</div>";
?>