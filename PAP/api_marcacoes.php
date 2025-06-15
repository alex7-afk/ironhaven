<?php
session_start();
header('Content-Type: application/json');

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

    // Read existing appointments
    $filename = 'appointments.json';
    $appointments = [];
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $appointments = json_decode($json, true) ?: [];
    }

   // Prevent overlapping appointments (max 1 por hora)
    $start = $data['start'] ?? '';
    $end   = $data['end'] ?? '';
    foreach ($appointments as $appt) {
        if (($start < $appt['end']) && ($end > $appt['start'])) {
            echo json_encode(['success' => false, 'error' => 'Horário indisponível']);
            exit();
        }
    }

    // Find the next available unique ID
    $maxId = 0;
    foreach ($appointments as $appt) {
        if (isset($appt['id']) && $appt['id'] > $maxId) {
            $maxId = $appt['id'];
        }
    }
    $newId = $maxId + 1;

    // Get appointment info from user input, including ID
    $newAppointment = [
        'id' => $newId,
        'title' => $_SESSION['username'],
        'emails' => $_SESSION['email'],
        'mensagem' => $data['mensagem'] ?? '',
        'appointment_type' => $data['appointment_type'] ?? 'training',
        'start' => $start,
        'end' => $end
    ];

    // Add new appointment
    $appointments[] = $newAppointment;
    file_put_contents($filename, json_encode($appointments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['success' => true]);
    exit();
}

// GET: Return all appointments
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filename = 'appointments.json';
    $appointments = [];
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $appointments = json_decode($json, true) ?: [];
    }
    echo json_encode($appointments);
    exit();
}

// Anything else: error
echo json_encode(['success' => false, 'error' => 'Requisição inválida']);
exit();
?>
