<?php
/**
 * Central database connection used by the application.  The connection
 * parameters change depending on whether we are running locally or on the
 * production server (Bluehost).  Include this file whenever a script needs
 * access to MySQL.
 */

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Localhost
    $dbConfig = [
        'host' => 'localhost',
        'db'   => 'ironhaven',
        'user' => 'root',
        'pass' => '',
    ];
} else {
    // (Bluehost)
    $dbConfig = [
        'host' => 'localhost',
        'db'   => 'vktmzhmy_ironhaven',
        'user' => 'vktmzhmy_alex',
        'pass' => 'pDam_@Rga5v?',
    ];
}

$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db']};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

/**
 * Helper for scripts that prefer mysqli instead of PDO.
 */
function getMysqliConnection(): mysqli {
    global $dbConfig;
    $conn = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['db']);
    if ($conn->connect_error) {
        throw new RuntimeException('MySQL connection failed: ' . $conn->connect_error);
    }
    return $conn;
}

?>