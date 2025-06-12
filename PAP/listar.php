<?php
header('Content-Type: application/json');

try {
  $pdo = new PDO("mysql:host=localhost;dbname=personal_trainer", "root", "");
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
