<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

require_once __DIR__ . '/db.php';

// Read POST data as JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['username']) || !isset($input['password'])) {
    echo json_encode(['success' => false, 'error' => 'Dados em falta!']);
    exit;
}

$username = $input['username'];
$password = $input['password'];

$stmt = $pdo->prepare('SELECT id, username, email, password, is_admin FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->execute([$username, $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'is_admin' => (bool)$user['is_admin']
    ];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = (bool)$user['is_admin'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Credenciais inválidas!']);
}
?>