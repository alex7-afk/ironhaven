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

// Read all contacts
$file = 'contacts.json';
$contacts = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Contactos Recebidos | Iron Haven</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    body { background: #18191c; color: #fff; font-family: 'Montserrat', Arial, sans-serif; }
    .table-container { max-width: 900px; margin: 40px auto 0 auto; background: #22242a; border-radius: 18px; padding: 32px 36px; box-shadow: 0 8px 32px rgba(0,0,0,0.23);}
    h2 { text-align: center; margin-bottom: 30px; font-size: 2rem; }
    .search-box { margin-bottom: 16px; width: 100%; padding: 10px; border-radius: 8px; border: none; font-size: 1rem; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px 10px; text-align: left; }
    th { background: #18191c; color: #fff; font-weight: 600; }
    tr:nth-child(even) { background: #21232a; }
    tr:nth-child(odd) { background: #22242a; }
    @media (max-width: 600px) {
      .table-container { padding: 5px; }
      th, td { font-size: 0.90em; }
    }
  </style>
</head>
<body>
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
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contacts as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['nome']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['mensagem']) ?></td>
          <td><?= htmlspecialchars($row['data']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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