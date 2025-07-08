<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

function is_admin() {
    if (isset($_SESSION['user']) && !empty($_SESSION['user']['is_admin'])) {
        return true;
    }
    if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_admin()) {
        echo json_encode(['success' => false, 'error' => 'Não autorizado']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || empty($data['title']) || empty($data['date'])) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO events (title, date, description) VALUES (?, ?, ?)');
    $stmt->execute([
        trim(strip_tags($data['title'])),
        trim($data['date']),
        trim(strip_tags($data['description'] ?? ''))
    ]);
    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query('SELECT id, title, date, description FROM events ORDER BY id DESC');
    echo json_encode($stmt->fetchAll());
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>