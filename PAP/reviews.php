<?php
// Substitute 'DB_USER' and 'DB_PASS' with your database username and password.
$conn = new mysqli('localhost', 'root', '', 'ironhaven');
if($conn->connect_error){
    die('Erro de ligação');
}

$result = $conn->query("SELECT username, review, created_at FROM reviews ORDER BY created_at DESC LIMIT 10");
$reviews = [];
while($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

header('Content-Type: application/json');
echo json_encode($reviews);

$conn->close();
?>
