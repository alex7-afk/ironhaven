<?php
require_once __DIR__ . '/db.php';
$token = $_GET['token'] ?? ($_POST['token'] ?? '');
$stmtTok = $pdo->prepare('SELECT email, expires FROM tokens WHERE token = ?');
$stmtTok->execute([$token]);
$tokenRow = $stmtTok->fetch();
$erro = '';
$success = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nova = $_POST['password'] ?? '';
    if(!$token || !$nova){
        $erro = 'Dados em falta.';
    } elseif(!$tokenRow || $tokenRow['expires'] < time()){
        $erro = 'Token inválido ou expirado.';
    } else {
        $email = $tokenRow['email'];
        $pdo->prepare('UPDATE users SET password = ? WHERE email = ?')->execute([password_hash($nova, PASSWORD_DEFAULT), $email]);
        $pdo->prepare('DELETE FROM tokens WHERE token = ?')->execute([$token]);
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