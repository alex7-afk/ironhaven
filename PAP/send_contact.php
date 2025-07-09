<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
        $nome = $_SESSION['user']['username'];
        $email = $_SESSION['user']['email'];
    } elseif (isset($_SESSION['username'])) {
        // fallback for older login handling
        $nome = $_SESSION['username'];
        $email = $_SESSION['email'] ?? '';
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Precisa de estar autenticado.']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }
 $mensagem = trim(strip_tags($data['mensagem'] ?? ''));
    if ($mensagem === '') {
        echo json_encode(['success' => false, 'error' => 'Todos os campos são obrigatórios']);
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO contacts (nome, email, mensagem, data) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$nome, $email, $mensagem]);
    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $isAdmin = isset($_SESSION['user']) && !empty($_SESSION['user']['is_admin']);
    if (!$isAdmin) {
        echo json_encode(['success' => false, 'error' => 'Não autorizado']);
        exit();
    }
    $stmt = $pdo->query('SELECT id, nome, email, mensagem, data FROM contacts ORDER BY id DESC');
    echo json_encode($stmt->fetchAll());
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();