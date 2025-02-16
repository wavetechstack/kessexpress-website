<?php
// Force error display
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>PHP Basic Test</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current File: " . __FILE__ . "</p>";
echo "<p>Server Time: " . date('Y-m-d H:i:s') . "</p>";
?>