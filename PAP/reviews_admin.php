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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['delete_id']) ? intval($_POST['delete_id']) : 0;
    if ($id > 0) {
        $stmt = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: reviews_admin.php');
        exit();
    }
}

$stmt = $pdo->query('SELECT id, username, review, rating, created_at FROM reviews ORDER BY created_at DESC');
$reviews = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Reviews | Iron Haven</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
</head>
<body class="contact-admin">
<div class="table-container">
    <h2>Reviews dos Utilizadores</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Utilizador</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reviews as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['username']) ?></td>
                <td><?= htmlspecialchars($r['review']) ?></td>
                <td><?= $r['rating'] ?></td>
                <td><?= $r['created_at'] ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $r['id'] ?>">
                        <button type="submit" onclick="return confirm('Eliminar review?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div style="text-align:center;margin-top:20px;">
        <a href="admin_dashboard.php" class="btn btn-primary">Voltar</a>
    </div>
</div>
</body>
</html>