<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
require_once __DIR__ . '/db.php';

try {
  $stmt = $pdo->prepare("INSERT INTO marcacoes (nome, email, data_hora, mensagem) VALUES (?, ?, ?, ?)");
  $stmt->execute([
    $data['nome'],
    $data['email'],
    $data['start'], // guardar apenas o início como data_hora
    $data['mensagem']
  ]);
  echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
  echo json_encode(['erro' => $e->getMessage()]);
}
