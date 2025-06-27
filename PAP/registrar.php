<?php
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$data = json_decode(file_get_contents('php://input'), true);

$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$username || !$email || !$password) {
    echo json_encode(['success' => false, 'error' => 'Todos os campos são obrigatórios!']);
    exit();
}

// Check if user/email exists
$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
$stmt->execute([$username, $email]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Utilizador ou email já existe!']);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, 0)');
if ($stmt->execute([$username, $email, $hashedPassword])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Erro ao gravar utilizador']);
}
exit();
?>