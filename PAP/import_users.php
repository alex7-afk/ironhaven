<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db.php';

// Load users from JSON file
$json = file_get_contents(__DIR__ . '/users.json');
$users = json_decode($json, true);

if (!$users) {
    die("No users found in users.json or JSON decode error.");
}

$imported = 0;
foreach ($users as $user) {
    $username = $user['username'];
    $email = $user['email'];
    $password = $user['password'];
    $is_admin = isset($user['is_admin']) ? (int)$user['is_admin'] : 0;

    // If the password is not hashed, hash it
    if (substr($password, 0, 4) !== '$2y$') {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        continue;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $password, $is_admin])) {
        $imported++;
    }
}


echo "Import completed! Users imported: $imported\n";
?>
