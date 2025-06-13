<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    echo json_encode([
        'logged_in' => true,
        'username' => $_SESSION['user']['username'],
        'email' => $_SESSION['user']['email']
    ]);
} elseif (isset($_SESSION['username'])) {
    // fallback for old session style
    echo json_encode([
        'logged_in' => true,
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email'] ?? ''
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
