<?php
session_start();
header('Content-Type: application/json');

// DEBUG
file_put_contents('debug_review.txt', print_r($_SESSION, true) . "\n\n" . file_get_contents('php://input'));

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
$mysqli = new mysqli("localhost", "root", "", "ironhaven");
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false, 'error' => 'Erro ao ligar ao MySQL: ' . $mysqli->connect_error]);
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
