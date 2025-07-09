<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

try {
  $res = $pdo->query("SELECT nome, data_hora FROM marcacoes");

  $eventos = [];
  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $eventos[] = [
      "title" => $row['nome'],
      "start" => $row['data_hora'],
    ];
  }

  echo json_encode($eventos);
} catch (PDOException $e) {
  echo json_encode([]);
}
