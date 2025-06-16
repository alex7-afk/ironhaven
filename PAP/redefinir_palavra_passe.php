<?php
$tokensFile = 'tokens.json';
$tokens = file_exists($tokensFile) ? json_decode(file_get_contents($tokensFile), true) : [];
$token = $_GET['token'] ?? ($_POST['token'] ?? '');
$erro = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nova = $_POST['password'] ?? '';
    if(!$token || !$nova){
        $erro = 'Dados em falta.';
    } elseif(!isset($tokens[$token]) || $tokens[$token]['expires'] < time()){
        $erro = 'Token inválido ou expirado.';
    } else {
        $email = $tokens[$token]['email'];
        $users = json_decode(file_get_contents('users.json'), true);
        foreach($users as &$u){
            if($u['email'] === $email){
                $u['password'] = password_hash($nova, PASSWORD_DEFAULT);
                break;
            }
        }
        file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        unset($tokens[$token]);
        file_put_contents($tokensFile, json_encode($tokens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $success = 'Palavra-passe atualizada!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Redefinir Palavra-passe</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="register-wrapper">
  <form method="post" class="register-form">
    <h2>Redefinir Palavra-passe</h2>
    <?php if($erro): ?>
      <div class="modal-error" style="display:block;"><?= htmlspecialchars($erro) ?></div>
    <?php elseif($success): ?>
      <div class="modal-success" style="display:block;"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <?php if(!$success): ?>
      <label for="password">Nova palavra-passe</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Guardar</button>
    <?php endif; ?>
  </form>
</div>
</body>
</html>