<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

// AUTH CHECK
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Precisa de estar autenticado.']);
    exit;
}

// GET DATA
$data = json_decode(file_get_contents('php://input'), true);
$review = isset($data['review']) ? trim($data['review']) : '';
$rating = isset($data['rating']) ? intval($data['rating']) : 0;
if ($review === '' || $rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos.']);
    exit;
}

// INSERT USING PDO
try {
    $stmt = $pdo->prepare(
        "INSERT INTO reviews (user_id, username, review, rating, created_at) VALUES (?, ?, ?, ?, NOW())"
    );
    $userId = $_SESSION['user']['id'] ?? 0;
    $stmt->execute([$userId, $_SESSION['user']['username'], $review, $rating]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Erro na base de dados: ' . $e->getMessage()]);
}
