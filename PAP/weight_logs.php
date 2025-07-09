<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']) && !isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'Precisa de login']);
        exit();
    }
   $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['weight'])) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }
    $username = $_SESSION['user']['username'] ?? $_SESSION['username'];
    $weight = floatval($data['weight']);
    $stmt = $pdo->prepare('INSERT INTO weights (username, weight, date) VALUES (?, ?, CURDATE())');
    $stmt->execute([$username, $weight]);
    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['user']) && !isset($_SESSION['username'])) {
        echo json_encode([]);
        exit();
    }
    $username = $_SESSION['user']['username'] ?? $_SESSION['username'];
    $stmt = $pdo->prepare('SELECT id, username, weight, date FROM weights WHERE username = ? ORDER BY id DESC');
    $stmt->execute([$username]);
    echo json_encode($stmt->fetchAll());
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
?>