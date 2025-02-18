<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>MySQL Connection Test</h2>";

try {
    // Load environment variables from .env file
    if (file_exists(__DIR__ . '/../.env')) {
        $envFile = file_get_contents(__DIR__ . '/../.env');
        $lines = explode("\n", $envFile);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                putenv(trim($key) . '=' . trim($value));
            }
        }
    }

    // Database credentials from .env
    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    
    echo "<p>Testing connection to:</p>";
    echo "<ul>";
    echo "<li>Host: " . htmlspecialchars($host) . "</li>";
    echo "<li>Database: " . htmlspecialchars($dbname) . "</li>";
    echo "<li>Username: " . htmlspecialchars($username) . "</li>";
    echo "</ul>";

    // Test MySQL connection
    $mysqli = new mysqli($host, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        throw new Exception($mysqli->connect_error);
    }
    
    echo "<div style='color: green; margin: 10px 0;'>";
    echo "✓ MySQL Connection successful!<br>";
    echo "Server version: " . $mysqli->server_info;
    echo "</div>";

    // Test query
    $result = $mysqli->query("SHOW TABLES");
    if ($result) {
        echo "<h3>Available tables:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . htmlspecialchars($row[0]) . "</li>";
        }
        echo "</ul>";
    }
    
    $mysqli->close();

} catch (Exception $e) {
    echo "<div style='color: red; margin: 10px 0;'>";
    echo "✗ Error: " . htmlspecialchars($e->getMessage());
    echo "</div>";
}

// Show PHP Configuration
echo "<h3>PHP Configuration:</h3>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>MySQL Extensions:</li>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    if (stripos($ext, 'mysql') !== false || stripos($ext, 'pdo') !== false) {
        echo "<li style='margin-left: 20px;'>" . htmlspecialchars($ext) . "</li>";
    }
}
echo "</ul>";
?>
