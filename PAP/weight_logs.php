<?php
session_start();
header('Content-Type: application/json');

$filename = 'weights.json';
$weights = [];
if (file_exists($filename)) {
    $weights = json_decode(file_get_contents($filename), true) ?: [];
}

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
    $maxId = 0;
    foreach ($weights as $log) {
        if (isset($log['id']) && $log['id'] > $maxId) {
            $maxId = $log['id'];
        }
    }
    $weights[] = [
        'id' => $maxId + 1,
        'username' => $username,
        'weight' => $weight,
        'date' => date('Y-m-d')
    ];
    file_put_contents($filename, json_encode($weights, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['success' => true]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['user']) && !isset($_SESSION['username'])) {
        echo json_encode([]);
        exit();
    }
    $username = $_SESSION['user']['username'] ?? $_SESSION['username'];
    $userLogs = array_values(array_filter($weights, function($log) use ($username) {
        return $log['username'] === $username;
    }));
    echo json_encode($userLogs);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
?>