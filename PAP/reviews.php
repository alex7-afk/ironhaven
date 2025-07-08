<?php
require_once __DIR__ . '/db.php';

try {
    $conn = getMysqliConnection();
} catch (Exception $e) {
    die('Erro de ligação: ' . $e->getMessage());
}
$result = $conn->query("SELECT username, review, rating, created_at FROM reviews ORDER BY created_at DESC LIMIT 10");

$reviews = [];
while($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

header('Content-Type: application/json');
echo json_encode($reviews);

$conn->close();
?>
