<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$username || !$email || !$password) {
    echo json_encode(['success' => false, 'error' => 'Todos os campos são obrigatórios!']);
    exit();
}

// Load users
$file = 'users.json';
$users = [];
if (file_exists($file)) {
    $users = json_decode(file_get_contents($file), true) ?: [];
}

// Check if user/email exists
foreach ($users as $user) {
    if ($user['username'] === $username) {
        echo json_encode(['success' => false, 'error' => 'Nome de utilizador já existe!']);
        exit();
    }
    if ($user['email'] === $email) {
        echo json_encode(['success' => false, 'error' => 'Email já registado!']);
        exit();
    }
}

// Hash the password!
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Add new user
$users[] = [
    'username' => $username,
    'email' => $email,
    'password' => $hashedPassword,
    'is_admin' => false
];

// Save back to JSON
file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['success' => true]);
exit();
?>