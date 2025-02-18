<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Setting File Permissions</h1>";

// Directory containing PHP files
$dir = __DIR__;

// Function to set permissions
function setPermissions($path) {
    $result = chmod($path, 0644); // Files get 644
    if (is_dir($path)) {
        $result = chmod($path, 0755); // Directories get 755
    }
    return $result;
}

// Process directory
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

echo "<pre>\nSetting permissions for files and directories:\n\n";

foreach ($iterator as $item) {
    $path = $item->getPathname();
    $result = setPermissions($path);
    echo $path . " - " . ($result ? "SUCCESS" : "FAILED") . "\n";
}

echo "\nPermissions update complete.</pre>";

// Display current permissions
echo "<h2>Current Permissions:</h2><pre>";
system('ls -la ' . escapeshellarg($dir));
echo "</pre>";
?>
