<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>cPanel MySQL Connection Test</h2>";

try {
    // Load environment variables from .env file
    $envFile = __DIR__ . '/../.env';
    $envVars = [];

    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                $envVars[$key] = $value;
            }
        }
    }

    // Database credentials
    $host = $envVars['DB_HOST'] ?? '127.0.0.1';
    $port = $envVars['DB_PORT'] ?? '3306';
    $dbname = $envVars['DB_DATABASE'] ?? '';
    $username = $envVars['DB_USERNAME'] ?? '';
    $password = $envVars['DB_PASSWORD'] ?? '';

    echo "<h3>Connection Details:</h3>";
    echo "<ul>";
    echo "<li>Host: " . htmlspecialchars($host) . "</li>";
    echo "<li>Port: " . htmlspecialchars($port) . "</li>";
    echo "<li>Database: " . htmlspecialchars($dbname) . "</li>";
    echo "<li>Username: " . htmlspecialchars($username) . "</li>";
    echo "</ul>";

    // Test MySQLi Connection
    echo "<h3>Testing MySQLi Connection:</h3>";
    $mysqli = new mysqli($host, $username, $password, $dbname, $port);
    
    if ($mysqli->connect_error) {
        throw new Exception("MySQLi Connection Error: " . $mysqli->connect_error);
    }
    
    echo "<div style='color: green; margin: 10px 0;'>";
    echo "✓ MySQLi Connection successful!<br>";
    echo "Server version: " . $mysqli->server_info . "<br>";
    echo "Client version: " . mysqli_get_client_info() . "<br>";
    echo "</div>";

    // Test PDO Connection
    echo "<h3>Testing PDO Connection:</h3>";
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<div style='color: green; margin: 10px 0;'>";
    echo "✓ PDO Connection successful!<br>";
    echo "PDO Client Version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
    echo "PDO Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
    echo "</div>";

    // Test Database Operations
    echo "<h3>Database Information:</h3>";
    
    // Show Tables
    $tables = $mysqli->query("SHOW TABLES");
    echo "<h4>Available Tables:</h4>";
    echo "<ul>";
    while ($row = $tables->fetch_array()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";

    // Show Create Privileges
    $result = $mysqli->query("SHOW GRANTS");
    echo "<h4>User Privileges:</h4>";
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";

    $mysqli->close();

} catch (Exception $e) {
    echo "<div style='color: red; margin: 10px 0;'>";
    echo "✗ Error: " . htmlspecialchars($e->getMessage()) . "<br>";
    
    echo "<div style='margin-top: 10px; padding: 10px; background: #fff3f3;'>";
    echo "<strong>Troubleshooting Steps:</strong><br>";
    
    if (strpos($e->getMessage(), "Access denied") !== false) {
        echo "1. Verify database credentials in .env file<br>";
        echo "2. Check if the database user has proper permissions in cPanel<br>";
        echo "3. Ensure the database name includes your cPanel username prefix<br>";
    } elseif (strpos($e->getMessage(), "Connection refused") !== false) {
        echo "1. Check if you're using the correct host (try '127.0.0.1' instead of 'localhost')<br>";
        echo "2. Verify the MySQL server port (default: 3306)<br>";
        echo "3. Contact your hosting provider if the issue persists<br>";
    } else {
        echo "1. Verify all database credentials in .env file<br>";
        echo "2. Check MySQL server status with your hosting provider<br>";
        echo "3. Ensure your hosting package includes MySQL access<br>";
    }
    echo "</div></div>";
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

// Environment Status
echo "<h3>Environment Status:</h3>";
echo "<ul>";
echo "<li>.env file " . (file_exists($envFile) ? "exists" : "not found") . "</li>";
echo "<li>Database configuration " . (!empty($dbname) && !empty($username) ? "present" : "missing") . "</li>";
echo "<li>MySQL Support: " . (extension_loaded('mysqli') && extension_loaded('pdo_mysql') ? "✓ Available" : "✗ Not available") . "</li>";
echo "</ul>";

// Configuration Guide
echo "<h3>Configuration Guide:</h3>";
echo "<div style='background: #f5f5f5; padding: 15px; border-radius: 5px;'>";
echo "<p>To configure MySQL in cPanel:</p>";
echo "<ol>";
echo "<li>Login to cPanel</li>";
echo "<li>Navigate to 'MySQL Databases'</li>";
echo "<li>Create a new database (note the full name with prefix)</li>";
echo "<li>Create a new database user</li>";
echo "<li>Add the user to the database with 'ALL PRIVILEGES'</li>";
echo "<li>Update your .env file with the credentials</li>";
echo "</ol>";
echo "<p>Example .env configuration:</p>";
echo "<pre>";
echo "DB_CONNECTION=mysql\n";
echo "DB_HOST=127.0.0.1\n";
echo "DB_PORT=3306\n";
echo "DB_DATABASE=cpanelusername_databasename\n";
echo "DB_USERNAME=cpanelusername_dbuser\n";
echo "DB_PASSWORD=your_secure_password";
echo "</pre>";
echo "</div>";
?>
