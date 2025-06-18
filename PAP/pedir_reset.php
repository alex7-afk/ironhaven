<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';
$data = json_decode(file_get_contents('php://input'), true);
if(!$data || !isset($data['username'])){
    echo json_encode(['success'=>false,'error'=>'Dados em falta.']);
    exit;
}
$usernameOrEmail = $data['username'];
$stmt = $pdo->prepare('SELECT email FROM users WHERE username = ? OR email = ? LIMIT 1');
$stmt->execute([$usernameOrEmail, $usernameOrEmail]);
$userEmail = $stmt->fetchColumn();
if(!$userEmail){
    echo json_encode(['success'=>false,'error'=>'Utilizador não encontrado!']);
    exit;
}
$token = bin2hex(random_bytes(16));
$stmt = $pdo->prepare('INSERT INTO tokens (token, email, expires) VALUES (?, ?, ?)');
$stmt->execute([$token, $userEmail, time()+3600]);
$resetLink = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=="off") ? "https" : "http") .
    "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/redefinir_palavra_passe.php?token=".$token;
// Tentar enviar email (pode falhar em desenvolvimento)
@mail($userEmail, 'Recuperação de palavra-passe', "Visite: $resetLink");

echo json_encode(['success'=>true,'link'=>$resetLink]);