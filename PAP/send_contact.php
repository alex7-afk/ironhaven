<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }

    $nome = filter_var(trim($data['nome'] ?? ''), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $mensagem = filter_var(trim($data['mensagem'] ?? ''), FILTER_SANITIZE_STRING);

    if ($nome === '' || $email === '' || $mensagem === '') {
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
    $file = 'contacts.json';
    $contacts = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    echo json_encode($contacts);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>