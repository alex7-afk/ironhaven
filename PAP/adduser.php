<?php
require_once __DIR__ . '/db.php';

$username = "admin";
$password = "admin123";
$hashed   = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->execute([$username, $hashed]);
    echo "User created. Username: $username, Password: $password<br>";
    echo "Hashed: $hashed";
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
