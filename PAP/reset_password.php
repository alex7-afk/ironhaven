<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['username']) || !isset($data['oldPassword']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Dados em falta.']);
    exit;
$usernameOrEmail = $data['username'];
$oldPassword = $data['oldPassword'];
$newPassword = $data['password'];

$stmt = $pdo->prepare('SELECT id, password, email FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->execute([$usernameOrEmail, $usernameOrEmail]);
$user = $stmt->fetch();

if ($user) {
    if (password_verify($oldPassword, $user['password'])) {
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $user['id']]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Palavra-passe atual incorreta!']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Utilizador não encontrado!']);
}
?>
