<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if(!$data || !isset($data['username'])){
    echo json_encode(['success'=>false,'error'=>'Dados em falta.']);
    exit;
}
$usernameOrEmail = $data['username'];
$usersFile = 'users.json';
if(!file_exists($usersFile)){
    echo json_encode(['success'=>false,'error'=>'Base de dados não encontrada!']);
    exit;
}
$users = json_decode(file_get_contents($usersFile), true);
$userEmail = null;
foreach($users as $user){
    if($user['username'] === $usernameOrEmail || $user['email'] === $usernameOrEmail){
        $userEmail = $user['email'];
        break;
    }
}
if(!$userEmail){
    echo json_encode(['success'=>false,'error'=>'Utilizador não encontrado!']);
    exit;
}
$token = bin2hex(random_bytes(16));
$tokensFile = 'tokens.json';
$tokens = file_exists($tokensFile) ? json_decode(file_get_contents($tokensFile), true) : [];
$tokens[$token] = ['email'=>$userEmail,'expires'=>time()+3600];
file_put_contents($tokensFile, json_encode($tokens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$resetLink = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=="off") ? "https" : "http") .
    "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/redefinir_palavra_passe.php?token=".$token;
// Tentar enviar email (pode falhar em desenvolvimento)
@mail($userEmail, 'Recuperação de palavra-passe', "Visite: $resetLink");

echo json_encode(['success'=>true,'link'=>$resetLink]);