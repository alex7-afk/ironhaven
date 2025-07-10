<?php
session_start();
date_default_timezone_set('UTC');
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: 0');
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

    $startStr = $data['start'] ?? '';
    $endStr   = $data['end'] ?? '';

    try {
        $startDt = new DateTime($startStr);
        $endDt   = new DateTime($endStr);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Formato de data inválido']);
        exit();
    }

    // Convert to UTC for storage
    $startUtc = clone $startDt;
    $endUtc   = clone $endDt;
    $startUtc->setTimezone(new DateTimeZone('UTC'));
    $endUtc->setTimezone(new DateTimeZone('UTC'));
    $start = $startUtc->format('Y-m-d H:i:s');
    $end   = $endUtc->format('Y-m-d H:i:s');

    // Prevent overlapping appointments for the same user
    $check = $pdo->prepare('SELECT COUNT(*) FROM appointments WHERE email = ? AND start < ? AND end > ?');
    $check->execute([$_SESSION['email'], $end, $start]);
    if ($check->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'error' => 'Já possui uma marcação nessa hora']);
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
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) {
        try {
            $start = new DateTime($r['start'], new DateTimeZone('UTC'));
            $end   = new DateTime($r['end'], new DateTimeZone('UTC'));
            // Return ISO strings with timezone so client converts correctly
            $r['start'] = $start->format('Y-m-d\TH:i:sP');
            $r['end']   = $end->format('Y-m-d\TH:i:sP');
        } catch (Exception $e) {
            // leave as-is on error
        }
    }
    echo json_encode($rows);
    exit();
}

// Anything else: error
echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>