<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>MySQL Connection Test</h2>";

// Load environment variables from .env file
function loadEnv($path) {
    if (file_exists($path)) {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

// Load .env file
$envPath = __DIR__ . '/../.env';
loadEnv($envPath);

// Database credentials
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_DATABASE') ?: 'f281vxk316o6_laravel';
$dbUser = getenv('DB_USERNAME') ?: 'f281vxk316o6_laraveluser';
$dbPass = getenv('DB_PASSWORD') ?: '';

echo "<h3>Connection Details:</h3>";
echo "Host: " . htmlspecialchars($dbHost) . "<br>";
echo "Database: " . htmlspecialchars($dbName) . "<br>";
echo "Username: " . htmlspecialchars($dbUser) . "<br>";

try {
    // Try PDO connection
    echo "<h3>Testing PDO Connection:</h3>";
    $pdoDsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($pdoDsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:green'>PDO Connection successful!</span><br>";
    echo "PDO MySQL Client Version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
    echo "PDO MySQL Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
} catch (PDOException $e) {
    echo "<span style='color:red'>PDO Connection failed: " . htmlspecialchars($e->getMessage()) . "</span><br>";
}

try {
    // Try mysqli connection
    echo "<h3>Testing MySQLi Connection:</h3>";
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($mysqli->connect_error) {
        throw new Exception($mysqli->connect_error);
    }
    echo "<span style='color:green'>MySQLi Connection successful!</span><br>";
    echo "MySQLi Client Info: " . mysqli_get_client_info() . "<br>";
    echo "MySQLi Server Info: " . $mysqli->server_info . "<br>";
    $mysqli->close();
} catch (Exception $e) {
    echo "<span style='color:red'>MySQLi Connection failed: " . htmlspecialchars($e->getMessage()) . "</span><br>";
}

// Test creating a table
try {
    echo "<h3>Testing Table Creation:</h3>";
    $pdo = new PDO($pdoDsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Try to create a test table
    $sql = "CREATE TABLE IF NOT EXISTS mysql_test (
        id INT AUTO_INCREMENT PRIMARY KEY,
        test_column VARCHAR(255)
    )";
    $pdo->exec($sql);
    echo "<span style='color:green'>Test table created successfully!</span><br>";
    
    // Clean up - drop the test table
    $pdo->exec("DROP TABLE mysql_test");
    echo "Test table cleaned up successfully.<br>";
} catch (PDOException $e) {
    echo "<span style='color:red'>Table operation failed: " . htmlspecialchars($e->getMessage()) . "</span><br>";
}

echo "<h3>PHP Information:</h3>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Loaded PHP Extensions:<br>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    if (strpos($ext, 'mysql') !== false || strpos($ext, 'pdo') !== false) {
        echo "- " . htmlspecialchars($ext) . "<br>";
    }
}

?>
