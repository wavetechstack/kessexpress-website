<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

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
                putenv("$key=$value");
            }
        }
    }

    // Determine database type
    $dbConnection = $envVars['DB_CONNECTION'] ?? getenv('DB_CONNECTION') ?? 'pgsql';

    echo "<h3>Environment Information:</h3>";
    echo "<ul>";
    echo "<li>Database Type: " . htmlspecialchars(strtoupper($dbConnection)) . "</li>";

    if ($dbConnection === 'pgsql') {
        // PostgreSQL Connection (Replit)
        $databaseUrl = getenv('DATABASE_URL');
        if (empty($databaseUrl)) {
            throw new Exception("DATABASE_URL is not set. Required for PostgreSQL connection.");
        }

        $dbConfig = parse_url($databaseUrl);
        $host = $dbConfig['host'];
        $port = $dbConfig['port'];
        $dbname = ltrim($dbConfig['path'], '/');
        $username = $dbConfig['user'];
        $password = $dbConfig['pass'];

        echo "<li>Host: " . htmlspecialchars($host) . "</li>";
        echo "<li>Port: " . htmlspecialchars($port) . "</li>";
        echo "<li>Database: " . htmlspecialchars($dbname) . "</li>";
        echo "<li>Username: " . htmlspecialchars($username) . "</li>";
        echo "</ul>";

        // Test PostgreSQL connection
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<div style='color: green; margin: 10px 0;'>";
        echo "✓ PostgreSQL Connection successful!<br>";
        echo "Server version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        echo "</div>";

        // Test query
        $tables = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        echo "<h3>Available tables:</h3>";
        echo "<ul>";
        while ($table = $tables->fetch(PDO::FETCH_COLUMN)) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";

    } else {
        // MySQL Connection (cPanel)
        $host = $envVars['DB_HOST'] ?? getenv('DB_HOST') ?? '127.0.0.1';
        $port = $envVars['DB_PORT'] ?? getenv('DB_PORT') ?? '3306';
        $dbname = $envVars['DB_DATABASE'] ?? getenv('DB_DATABASE') ?? '';
        $username = $envVars['DB_USERNAME'] ?? getenv('DB_USERNAME') ?? '';
        $password = $envVars['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';

        echo "<li>Host: " . htmlspecialchars($host) . "</li>";
        echo "<li>Port: " . htmlspecialchars($port) . "</li>";
        echo "<li>Database: " . htmlspecialchars($dbname) . "</li>";
        echo "<li>Username: " . htmlspecialchars($username) . "</li>";
        echo "</ul>";

        $mysqli = new mysqli($host, $username, $password, $dbname, $port);
        if ($mysqli->connect_error) {
            throw new Exception($mysqli->connect_error);
        }

        echo "<div style='color: green; margin: 10px 0;'>";
        echo "✓ MySQL Connection successful!<br>";
        echo "Server version: " . $mysqli->server_info;
        echo "</div>";

        // Test query
        $result = $mysqli->query("SHOW TABLES");
        echo "<h3>Available tables:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . htmlspecialchars($row[0]) . "</li>";
        }
        echo "</ul>";
        $mysqli->close();
    }

} catch (Exception $e) {
    echo "<div style='color: red; margin: 10px 0;'>";
    echo "✗ Error: " . htmlspecialchars($e->getMessage());

    echo "<div style='margin-top: 10px; padding: 10px; background: #fff3f3;'>";
    echo "<strong>Troubleshooting Steps:</strong><br>";

    if ($dbConnection === 'pgsql') {
        echo "PostgreSQL Troubleshooting:<br>";
        echo "1. Verify DATABASE_URL environment variable is set correctly<br>";
        echo "2. Check if PostgreSQL service is running<br>";
        echo "3. Verify network connectivity to PostgreSQL server<br>";
    } else {
        echo "MySQL Troubleshooting:<br>";
        if (strpos($e->getMessage(), "No such file or directory") !== false) {
            echo "1. Try changing 'localhost' to '127.0.0.1' in your .env file<br>";
            echo "2. Verify MySQL server is running<br>";
            echo "3. Check if MySQL socket file exists and is accessible<br>";
        } elseif (strpos($e->getMessage(), "Access denied") !== false) {
            echo "1. Verify database credentials in .env file<br>";
            echo "2. Confirm database user has proper permissions<br>";
            echo "3. Try connecting with mysql command line tool to verify credentials<br>";
        }
    }
    echo "</div></div>";
}

// Show PHP Configuration
echo "<h3>PHP Configuration:</h3>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>Database Extensions:</li>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    if (stripos($ext, 'mysql') !== false || stripos($ext, 'pgsql') !== false || stripos($ext, 'pdo') !== false) {
        echo "<li style='margin-left: 20px;'>" . htmlspecialchars($ext) . "</li>";
    }
}
echo "</ul>";

// Environment Status
echo "<h3>Environment Status:</h3>";
echo "<ul>";
echo "<li>.env file " . (file_exists($envFile) ? "exists" : "not found") . "</li>";
echo "<li>Database configuration " . ($dbConnection === 'pgsql' ? 
    (getenv('DATABASE_URL') ? "present (PostgreSQL)" : "missing DATABASE_URL") : 
    (!empty($dbname) && !empty($username) ? "present (MySQL)" : "missing MySQL credentials")) . "</li>";
echo "</ul>";
?>