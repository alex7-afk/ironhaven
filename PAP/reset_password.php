<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['username']) || !isset($data['oldPassword']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Dados em falta.']);
    exit;
}

$usernameOrEmail = $data['username'];
$oldPassword = $data['oldPassword'];
$newPassword = $data['password'];
$usersFile = 'users.json';

if (!file_exists($usersFile)) {
    echo json_encode(['success' => false, 'error' => 'Base de dados não encontrada!']);
    exit;
}

$users = json_decode(file_get_contents($usersFile), true);
if (!$users) {
    echo json_encode(['success' => false, 'error' => 'Erro ao ler base de dados!']);
    exit;
}

$found = false;
foreach ($users as &$user) {
    if ($user['username'] === $usernameOrEmail || $user['email'] === $usernameOrEmail) {
        // Check old password (supports both hashed and plain text)
        if ((substr($user['password'], 0, 4) === '$2y$' && password_verify($oldPassword, $user['password']))
            || $user['password'] === $oldPassword) {
            $user['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $found = true;
        } else {
            echo json_encode(['success' => false, 'error' => 'Palavra-passe atual incorreta!']);
            exit;
        }
        break;
    }
}
unset($user);

if ($found) {
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Utilizador não encontrado!']);
}
?>
