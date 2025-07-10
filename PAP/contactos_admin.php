<?php
session_start();

// Only allow logged-in admin user
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

require_once __DIR__ . '/db.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: contactos_admin.php');
    exit();
}

// Read all contacts
$stmt = $pdo->query('SELECT id, nome, email, mensagem, data FROM contacts ORDER BY id DESC');
$contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Contactos Recebidos | Iron Haven</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <!-- admin specific styles moved to style.css -->
</head>
<body class="contact-admin">
  <div class="table-container">
    <h2>Mensagens Recebidas</h2>
    <input type="text" id="searchBox" class="search-box" placeholder="Pesquisar por nome ou email...">
    <table id="contactsTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Mensagem</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contacts as $row): ?>
        
        <?php endforeach; ?>
      </tbody>
    </table>
    <div style="text-align:center;margin-top:20px;">
      <a href="admin_dashboard.php" class="btn btn-primary">Voltar</a>
    </div>
  </div>
  <script>
    const searchBox = document.getElementById('searchBox');
    searchBox.addEventListener('keyup', function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll("#contactsTable tbody tr");
      rows.forEach(row => {
        row.style.display = [...row.children].some(td => td.textContent.toLowerCase().includes(filter)) ? "" : "none";
      });
    });
  </script>
</body>
</html>