<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Basic PHP Test</h1>";
echo "<p>PHP is working correctly if you can see this message.</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";

// Display server information
echo "<h2>Server Information:</h2>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
?>