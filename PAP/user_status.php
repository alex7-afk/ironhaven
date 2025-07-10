<?php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: 0');

if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    echo json_encode([
        'logged_in' => true,
        'username' => $_SESSION['user']['username'],
        'email' => $_SESSION['user']['email'],
        'is_admin' => !empty($_SESSION['user']['is_admin'])
    ]);
} elseif (isset($_SESSION['username'])) {
    // fallback for old session style
    echo json_encode([
        'logged_in' => true,
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email'] ?? '',
        'is_admin' => !empty($_SESSION['is_admin'])
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
