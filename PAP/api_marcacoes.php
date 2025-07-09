<?php
session_start();
// horario de Portugal
date_default_timezone_set('Europe/Lisbon');
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

    $start = $data['start'] ?? '';
    $end   = $data['end'] ?? '';

    try {
        // Ensure the datetimes are valid but keep original local times
        new DateTime($start);
        new DateTime($end);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Formato de data inválido']);
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
            // Return datetimes without timezone so FullCalendar treats them as local
            $r['start'] = (new DateTime($r['start']))->format('Y-m-d\TH:i:s');
            $r['end']   = (new DateTime($r['end']))->format('Y-m-d\TH:i:s');
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