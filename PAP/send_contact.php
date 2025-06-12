<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'Precisa de estar autenticado.']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }

    $nome = $_SESSION['user']['username'];
    $email = $_SESSION['user']['email'];
    $mensagem = filter_var(trim($data['mensagem'] ?? ''), FILTER_SANITIZE_STRING);

    if ($mensagem === '') {
        echo json_encode(['success' => false, 'error' => 'Todos os campos são obrigatórios']);
        exit();
    }

    $file = 'contacts.json';
    $contacts = [];
    if (file_exists($file)) {
        $contacts = json_decode(file_get_contents($file), true) ?: [];
    }

    $maxId = 0;
    foreach ($contacts as $c) {
        if (isset($c['id']) && $c['id'] > $maxId) {
            $maxId = $c['id'];
        }
    }
    $newId = $maxId + 1;

    $newContact = [
        'id' => $newId,
        'nome' => $nome,
        'email' => $email,
        'mensagem' => $mensagem,
        'data' => date('Y-m-d H:i:s')
    ];

    $contacts[] = $newContact;
    file_put_contents($file, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $isAdmin = isset($_SESSION['user']) && !empty($_SESSION['user']['is_admin']);
    if (!$isAdmin) {
        echo json_encode(['success' => false, 'error' => 'Não autorizado']);
        exit();
    }
    $file = 'contacts.json';
    $contacts = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    echo json_encode($contacts);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>