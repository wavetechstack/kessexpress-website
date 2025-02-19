<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Environment Test</h1>";

// Basic PHP Info
echo "<h2>PHP Environment</h2>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>Environment: " . (getenv('DATABASE_URL') ? 'Replit (PostgreSQL)' : 'cPanel (MySQL)') . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "</ul>";

// File System Permissions
echo "<h2>File System Permissions</h2>";
$criticalPaths = [
    '../storage' => 'Storage Directory',
    '../storage/logs' => 'Logs Directory',
    '../storage/framework' => 'Framework Directory',
    '../bootstrap/cache' => 'Cache Directory',
    '.' => 'Public Directory'
];

echo "<ul>";
foreach ($criticalPaths as $path => $description) {
    $fullPath = realpath(__DIR__ . '/' . $path);
    if ($fullPath) {
        echo "<li>$description ($path):<br>";
        echo "- Exists: Yes<br>";
        echo "- Readable: " . (is_readable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "- Writable: " . (is_writable($fullPath) ? 'Yes' : 'No') . "<br>";
        echo "- Permissions: " . substr(sprintf('%o', fileperms($fullPath)), -4) . "<br>";
        echo "</li>";
    } else {
        echo "<li>$description ($path): Not Found</li>";
    }
}
echo "</ul>";

// Environment Configuration
echo "<h2>Environment Configuration</h2>";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists<br>";
    if (is_readable($envFile)) {
        echo "✓ .env file is readable<br>";

        // Check database configuration
        $dbConnection = getenv('DB_CONNECTION') ?: 'pgsql';
        echo "Database Type: " . strtoupper($dbConnection) . "<br>";

        if ($dbConnection === 'pgsql') {
            $databaseUrl = getenv('DATABASE_URL');
            echo "PostgreSQL URL: " . ($databaseUrl ? '✓ Set' : '✗ Missing') . "<br>";
            if ($databaseUrl) {
                $dbConfig = parse_url($databaseUrl);
                echo "PostgreSQL Host: " . ($dbConfig['host'] ?? 'Not Set') . "<br>";
                echo "PostgreSQL Port: " . ($dbConfig['port'] ?? '5432') . "<br>";
                echo "PostgreSQL Database: " . (ltrim($dbConfig['path'] ?? '', '/')) . "<br>";
            }
        } else {
            echo "MySQL Host: " . (getenv('DB_HOST') ? '✓ Set' : '✗ Missing') . "<br>";
            echo "MySQL Database: " . (getenv('DB_DATABASE') ? '✓ Set' : '✗ Missing') . "<br>";
            echo "MySQL Username: " . (getenv('DB_USERNAME') ? '✓ Set' : '✗ Missing') . "<br>";
        }
    } else {
        echo "⚠ Warning: .env file is not readable<br>";
    }
} else {
    echo "⚠ Warning: .env file not found<br>";
}

// Required PHP Extensions
echo "<h2>Required PHP Extensions</h2>";
$requiredExtensions = [
    'pdo_mysql' => 'PDO MySQL',
    'pdo_pgsql' => 'PDO PostgreSQL',
    'openssl' => 'OpenSSL',
    'mbstring' => 'Multibyte String',
    'tokenizer' => 'Tokenizer',
    'xml' => 'XML',
    'ctype' => 'Ctype',
    'json' => 'JSON',
    'bcmath' => 'BCMath',
    'fileinfo' => 'FileInfo'
];

echo "<ul>";
foreach ($requiredExtensions as $ext => $name) {
    $loaded = extension_loaded($ext);
    echo "<li style='color: " . ($loaded ? 'green' : 'red') . "'>";
    echo "$name: " . ($loaded ? '✓' : '✗');
    echo "</li>";
}
echo "</ul>";

// Database Connection Test
echo "<h2>Database Test</h2>";
try {
    if (getenv('DATABASE_URL')) {
        // PostgreSQL Test (Replit)
        $databaseUrl = getenv('DATABASE_URL');
        $dbConfig = parse_url($databaseUrl);

        if ($dbConfig === false) {
            throw new Exception("Invalid DATABASE_URL format");
        }

        $host = $dbConfig['host'] ?? 'localhost';
        $port = $dbConfig['port'] ?? '5432';
        $dbname = ltrim($dbConfig['path'] ?? '', '/');
        $user = $dbConfig['user'] ?? '';
        $pass = $dbConfig['pass'] ?? '';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $pass);
        echo "PostgreSQL Connection: Success<br>";
        echo "PostgreSQL Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    } else {
        // MySQL Test (cPanel)
        $dbhost = getenv('DB_HOST') ?: '127.0.0.1';
        $dbname = getenv('DB_DATABASE');
        $dbuser = getenv('DB_USERNAME');
        $dbpass = getenv('DB_PASSWORD');

        if ($dbname && $dbuser) {
            $mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($mysqli->connect_error) {
                throw new Exception($mysqli->connect_error);
            }
            echo "MySQL Connection: Success<br>";
            echo "MySQL Version: " . $mysqli->server_info;
            $mysqli->close();
        } else {
            echo "MySQL Configuration: Not found (expected in cPanel environment)";
        }
    }
} catch (Exception $e) {
    echo "Database Error: " . $e->getMessage();
}

// PHP Configuration Values
echo "<h2>PHP Configuration</h2>";
$importantSettings = [
    'upload_max_filesize' => 'Upload Max Filesize',
    'post_max_size' => 'Post Max Size',
    'memory_limit' => 'Memory Limit',
    'max_execution_time' => 'Max Execution Time',
    'display_errors' => 'Display Errors'
];

echo "<ul>";
foreach ($importantSettings as $setting => $label) {
    echo "<li>$label: " . ini_get($setting) . "</li>";
}
echo "</ul>";
?>