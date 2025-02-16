<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function recursiveChmod($path, $dirPermissions, $filePermissions) {
    if (!file_exists($path)) {
        mkdir($path, $dirPermissions, true);
        echo "Created directory: $path\n";
    }

    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        if ($item->isDot()) continue;

        $itemPath = $item->getPathname();

        if ($item->isDir()) {
            chmod($itemPath, $dirPermissions);
            echo "Set directory permissions for: $itemPath\n";
            recursiveChmod($itemPath, $dirPermissions, $filePermissions);
        } else {
            chmod($itemPath, $filePermissions);
            echo "Set file permissions for: $itemPath\n";
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

foreach ($storageSubdirs as $dir) {
    $fullPath = $storagePath . $dir;
    if (!file_exists($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "Created directory: $fullPath\n";
    }
}

// Set permissions
recursiveChmod($storagePath, 0755, 0644);
recursiveChmod($bootstrapPath, 0755, 0644);

// Create .gitignore files to prevent committing cache
$gitignoreContent = "*\n!.gitignore\n";
file_put_contents($storagePath . '/framework/cache/.gitignore', $gitignoreContent);
file_put_contents($bootstrapPath . '/.gitignore', $gitignoreContent);

echo "\nPermissions update completed.\n";
echo "Storage path: $storagePath\n";
echo "Bootstrap cache path: $bootstrapPath\n";

// Create a test file to verify write permissions
try {
    $testFile = $storagePath . '/logs/test.log';
    file_put_contents($testFile, date('Y-m-d H:i:s') . " - Permission test successful\n");
    echo "Successfully wrote to test log file\n";
} catch (Exception $e) {
    echo "Failed to write test file: " . $e->getMessage() . "\n";
}
?>