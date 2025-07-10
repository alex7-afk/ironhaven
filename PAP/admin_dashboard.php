<?php
session_start();

$isAdmin = false;
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $isAdmin = !empty($_SESSION['user']['is_admin']);
} elseif (isset($_SESSION['is_admin'])) {
    $isAdmin = !empty($_SESSION['is_admin']);
}
if (!$isAdmin) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Painel de Administração | Iron Haven</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css" />
  <style>
    .admin-menu { display:flex; gap:20px; justify-content:center; margin-top:40px; flex-wrap:wrap; }
    .admin-menu a { text-decoration:none; }
  </style>
</head>
<body>
  <nav class="main-nav">
    <div class="nav-flex">
      <ul class="nav-links nav-left">
        <li><a href="index.php">Início</a></li>
        <li><a href="planos.html">Planos</a></li>
      </ul>
      <a href="index.php" class="nav-logo">
        <img src="logo2.png" alt="Iron Haven Logo">
      </a>
      <ul class="nav-links nav-right">
        <li><a href="#equipa">Equipa</a></li>
        <li class="dropdown"><a href="marcacoes.php">Marcações</a>
          <ul class="dropdown-menu">
            <li><a href="marcacoes.php?tipo=training">Treinos</a></li>
            <li><a href="marcacoes.php?tipo=consultation">Nutrição</a></li>
            <li><a href="marcacoes.php?tipo=evaluation">Avaliações</a></li>
          </ul>
        </li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="contactos.html">Contactos</a></li>
        <?php if(!empty($_SESSION['user']['is_admin']) || !empty($_SESSION['is_admin'])): ?>
          <li><a href="admin_dashboard.php">Admin</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="nav-btn">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="nav-btn">Login</a></li>
        <?php endif; ?>
      </ul>
      <button id="nav-toggle" aria-label="Abrir Menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>
  <main class="main-content">
    <h1 class="section-title">Painel de Administração</h1>
    <div class="admin-menu">
      <a href="marcacoes_admin.php" class="btn btn-primary">Marcações</a>
      <a href="contactos_admin.php" class="btn btn-primary">Contactos</a>
      <a href="reviews_admin.php" class="btn btn-primary">Reviews</a>
      <a href="events_admin.php" class="btn btn-primary">Eventos</a>
    </div>
  </main>
</body>
</html>