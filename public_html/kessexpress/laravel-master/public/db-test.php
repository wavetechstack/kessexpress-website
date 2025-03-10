<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database credentials
    $host = 'localhost';
    $dbname = 'f281vxk316o6_laravel';
    $username = 'f281vxk316o6_laraveluser';
    $password = getenv('DB_PASSWORD');
    $port = 3306;

    echo "<h2>MySQL Connection Test</h2>";
    echo "<p>Testing connection to:</p>";
    echo "<ul>";
    echo "<li>Host: " . htmlspecialchars($host) . "</li>";
    echo "<li>Database: " . htmlspecialchars($dbname) . "</li>";
    echo "<li>Username: " . htmlspecialchars($username) . "</li>";
    echo "<li>Port: " . htmlspecialchars($port) . "</li>";
    echo "</ul>";

    // Test MySQL connection
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<div style='color: green; margin: 10px 0;'>";
    echo "✓ MySQL Connection successful!<br>";
    echo "Server version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    echo "</div>";

    // Test query
    $result = $pdo->query("SHOW TABLES");
    if ($result) {
        echo "<h3>Available tables:</h3>";
        echo "<ul>";
        while ($row = $result->fetch(PDO::FETCH_COLUMN)) {
            echo "<li>" . htmlspecialchars($row) . "</li>";
        }
        echo "</ul>";
    }

} catch (Exception $e) {
    echo "<div style='color: red; margin: 10px 0;'>";
    echo "✗ Error: " . htmlspecialchars($e->getMessage());
    echo "</div>";
}

// PHP Environment Information
echo "<h3>PHP Environment:</h3>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "</ul>";

echo "<h3>MySQL Extensions:</h3>";
echo "<ul>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    if (stripos($ext, 'mysql') !== false || stripos($ext, 'pdo') !== false) {
        echo "<li>" . htmlspecialchars($ext) . "</li>";
    }
}
echo "</ul>";
?>