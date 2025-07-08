<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

// Only allow logged in users to POST (create booking)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
        echo json_encode(['success' => false, 'error' => 'Precisa de login para marcar!']);
        exit();
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
        exit();
    }

    // Prevent overlapping appointments
    $start = $data['start'] ?? '';
    $end   = $data['end'] ?? '';
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM appointments WHERE (start < ? AND end > ?)');
    $stmt->execute([$end, $start]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'error' => 'Horário indisponível']);
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO appointments (title, email, mensagem, appointment_type, start, end) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $_SESSION['username'],
        $_SESSION['email'],
        $data['mensagem'] ?? '',
        $data['appointment_type'] ?? 'training',
        $start,
        $end
    ]);

    echo json_encode(['success' => true]);
    exit();
}

// GET: Return all appointments
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query('SELECT id, title, email, mensagem, appointment_type, start, end FROM appointments ORDER BY id DESC');
    echo json_encode($stmt->fetchAll());
    exit();
}

// Anything else: error
echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>
