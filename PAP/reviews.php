<?php
require_once __DIR__ . '/db.php';

try {
    $stmt = $pdo->query(
        'SELECT username, review, rating, created_at FROM reviews ORDER BY created_at DESC LIMIT 10'
    );
    $reviews = $stmt->fetchAll();
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Expires: 0');
    echo json_encode($reviews);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro na base de dados: ' . $e->getMessage()]);
}