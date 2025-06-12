<?php
header('Content-Type: application/json');
session_start();

// Read POST data as JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['username']) || !isset($input['password'])) {
    echo json_encode(['success' => false, 'error' => 'Dados em falta!']);
    exit;
}

$username = $input['username'];
$password = $input['password'];

$usersFile = 'users.json';
if (!file_exists($usersFile)) {
    echo json_encode(['success' => false, 'error' => 'Base de dados em falta!']);
    exit;
}

$users = json_decode(file_get_contents($usersFile), true);
if (!$users) {
    echo json_encode(['success' => false, 'error' => 'Erro ao ler base de dados!']);
    exit;
}

$found = false;
foreach ($users as $user) {
    if (
        ($user['username'] === $username || $user['email'] === $username) &&
        (
            (substr($user['password'], 0, 4) === '$2y$'
                ? password_verify($password, $user['password'])
                : $user['password'] === $password
            )
        )
    ) {
        $found = true;

        // SESSION: For reviews (array with username/email, and id=null since JSON has no id)
        $_SESSION['user'] = [
            'id' => null,
            'username' => $user['username'],
            'email' => $user['email'],
            'is_admin' => !empty($user['is_admin'])
        ];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['is_admin'] = !empty($user['is_admin']);
        break;
    }
}

if ($found) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Credenciais inválidas!']);
}
?>
