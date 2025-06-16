<?php
$host = 'localhost';
$db = 'ironhaven';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$username = "admin";
$password = "admin123";
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed);
$stmt->execute();

echo "User created. Username: $username, Password: $password<br>";
echo "Hashed: $hashed";

$stmt->close();
$conn->close();
?>
