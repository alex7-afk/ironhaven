<?php
session_start();
require_once __DIR__ . '/db.php';

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

$pdo->exec("CREATE TABLE IF NOT EXISTS events (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), date DATE, description TEXT)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = trim($_POST['title'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    if (isset($_POST['delete'])) {
        if ($id > 0) {
            $stmt = $pdo->prepare('DELETE FROM events WHERE id=?');
            $stmt->execute([$id]);
        }
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE events SET title=?, date=?, description=? WHERE id=?');
            $stmt->execute([$title, $date, $desc, $id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO events (title, date, description) VALUES (?, ?, ?)');
            $stmt->execute([$title, $date, $desc]);
        }
    }
    header('Location: events_admin.php');
    exit();
}

$events = $pdo->query('SELECT id, title, date, description FROM events ORDER BY date DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Eventos | Iron Haven</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
    <script>
        function editEvent(id,title,date,desc){
            document.getElementById('id').value=id;
            document.getElementById('title').value=title;
            document.getElementById('date').value=date;
            document.getElementById('description').value=desc;
            document.getElementById('form-title').textContent='Editar Evento';
        }
        function clearForm(){
            document.getElementById('id').value='';
            document.getElementById('title').value='';
            document.getElementById('date').value='';
            document.getElementById('description').value='';
            document.getElementById('form-title').textContent='Novo Evento';
        }
    </script>
</head>
<body class="contact-admin">
<div class="table-container">
    <h2>Eventos</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Data</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $e): ?>
            <tr>
                <td><?= $e['id'] ?></td>
                <td><?= htmlspecialchars($e['title']) ?></td>
                <td><?= htmlspecialchars($e['date']) ?></td>
                <td><?= htmlspecialchars($e['description']) ?></td>
                <td>
                    <button onclick="editEvent('<?= $e['id'] ?>','<?= htmlspecialchars(addslashes($e['title'])) ?>','<?= $e['date'] ?>','<?= htmlspecialchars(addslashes($e['description'])) ?>')">Editar</button>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $e['id'] ?>">
                        <input type="hidden" name="delete" value="1">
                        <button type="submit" onclick="return confirm('Eliminar evento?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h3 id="form-title" style="margin-top:30px;">Novo Evento</h3>
    <form method="post" onreset="clearForm()">
        <input type="hidden" name="id" id="id">
        <input type="text" name="title" id="title" placeholder="Título" required>
        <input type="date" name="date" id="date" required>
        <textarea name="description" id="description" placeholder="Descrição"></textarea>
        <button type="submit">Guardar</button>
        <button type="reset">Limpar</button>
    </form>
</div>
</body>
</html>