<?php
session_start();
header('Content-Type: application/json');

$file = 'events.json';

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

    $events = [];
    if (file_exists($file)) {
        $events = json_decode(file_get_contents($file), true) ?: [];
    }

    $maxId = 0;
    foreach ($events as $e) {
        if (isset($e['id']) && $e['id'] > $maxId) {
            $maxId = $e['id'];
        }
    }
    $newId = $maxId + 1;

    $events[] = [
        'id' => $newId,
        'title' => trim(strip_tags($data['title'])),
        'date' => trim($data['date']),
        'description' => trim(strip_tags($data['description'] ?? ''))
    ];

    file_put_contents($file, json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $events = [];
    if (file_exists($file)) {
        $events = json_decode(file_get_contents($file), true) ?: [];
    }
    echo json_encode($events);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>