<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database credentials
    $host = 'localhost';
    $dbname = isset($_ENV['DB_DATABASE']) ? $_ENV['DB_DATABASE'] : 'your_database_name';
    $username = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'your_username';
    $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : '';

    echo "<h1>MySQL Connection Test</h1>";
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
echo "<h2>PHP Configuration:</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Loaded Extensions:<br>";
foreach (get_loaded_extensions() as $ext) {
    if (stripos($ext, 'mysql') !== false || stripos($ext, 'pdo') !== false) {
        echo "- " . htmlspecialchars($ext) . "<br>";
    }
}
?>