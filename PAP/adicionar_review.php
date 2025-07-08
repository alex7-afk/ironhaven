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

// DB CONNECTION
try {
    $mysqli = getMysqliConnection();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}

// INSERT
$user_id = 0; // JSON users
$username = $_SESSION['user']['username'];
$stmt = $mysqli->prepare("INSERT INTO reviews (user_id, username, review, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Erro no prepare: ' . $mysqli->error]);
    exit;
}
$stmt->bind_param("issi", $user_id, $username, $review, $rating);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Erro no execute: ' . $stmt->error]);
}
$stmt->close();
$mysqli->close();
