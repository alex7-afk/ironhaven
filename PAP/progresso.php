<?php
// progresso.php - Registo de peso e calculadora de calorias
session_start();

function calculate_bmr($weight, $height, $age, $gender) {
    if ($gender === 'male') {
        return 10 * $weight + 6.25 * $height - 5 * $age + 5;
    }
    return 10 * $weight + 6.25 * $height - 5 * $age - 161;
}

function get_activity_factor($activity) {
    switch ($activity) {
        case 'sedentary': return 1.2;
        case 'light': return 1.375;
        case 'moderate': return 1.55;
        case 'active': return 1.725;
        case 'very_active': return 1.9;
        default: return 1.2;
    }
}

function get_goal_adjustment($goal) {
    switch ($goal) {
        case 'lose': return -500;
        case 'gain': return 500;
        default: return 0;
    }
}

$weightDataFile = __DIR__ . '/weights.json';
if (!file_exists($weightDataFile)) {
    file_put_contents($weightDataFile, json_encode([]));
}
$weights = json_decode(file_get_contents($weightDataFile), true);
$logMessage = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_weight'])) {
        $newWeight = floatval($_POST['new_weight']);
        $weights[] = ['date' => date('Y-m-d'), 'weight' => $newWeight];
        file_put_contents($weightDataFile, json_encode($weights, JSON_PRETTY_PRINT));
        $logMessage = 'Registo de peso adicionado.';
    }

    if (isset($_POST['age'])) {
        $weight = floatval($_POST['weight']);
        $height = floatval($_POST['height']);
        $age = intval($_POST['age']);
        $gender = $_POST['gender'];
        $activity = $_POST['activity'];
        $goal = $_POST['goal'];

        $bmr = calculate_bmr($weight, $height, $age, $gender);
        $activityFactor = get_activity_factor($activity);
        $calories = $bmr * $activityFactor + get_goal_adjustment($goal);

        $result = 'O seu objetivo diário de calorias é: <b>' . round($calories) . ' kcal</b>.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progresso | Iron Haven</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .progress-page { max-width: 700px; margin: auto; padding: 20px; }
        .progress-page form {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        .progress-page label { display: block; margin-top: 10px; }
        .progress-page input,
        .progress-page select { width: 100%; padding: 8px; margin-top: 4px; border-radius: 4px; }
        .progress-page table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .progress-page th,
        .progress-page td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        .progress-page .result { margin-top: 15px; font-size: 1.2em; color: var(--accent); text-align: center; }
        .progress-page .message { color: #00c853; text-align: center; font-weight: bold; }
    </style>
</head>
<body class="progress-page">
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
        <li><a href="equipa.html">Equipa</a></li>
        <li><a href="marcacoes.php">Marcações</a></li>
        <li><a href="progresso.php">Progresso</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="sobre.html">Sobre</a></li>
        <li><a href="contactos.html">Contactos</a></li>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php" class="nav-btn" id="logout-link">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="nav-btn">Login</a></li>
        <?php endif; ?>
      </ul>
      <button id="nav-toggle" aria-label="Abrir Menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>

  <main class="main-content progress-page">
    <h2>Registe o seu Peso</h2>
    <?php if ($logMessage): ?>
        <p class="message"><?= $logMessage ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Peso de hoje (kg):
            <input type="number" step="0.1" name="new_weight" required>
        </label>
        <input type="submit" value="Adicionar Peso">
    </form>

    <h3>Histórico de Peso</h3>
    <?php if ($weights): ?>
    <table>
        <tr><th>Data</th><th>Peso (kg)</th></tr>
        <?php foreach ($weights as $entry): ?>
            <tr><td><?= htmlspecialchars($entry['date']) ?></td><td><?= htmlspecialchars($entry['weight']) ?></td></tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Ainda não existem registos.</p>
    <?php endif; ?>

    <h2>Calculadora de Calorias</h2>
    <form method="post">
        <label>Idade:
            <input type="number" name="age" required min="10" max="120">
        </label>
        <label>Sexo:
            <select name="gender">
                <option value="male">Masculino</option>
                <option value="female">Feminino</option>
            </select>
        </label>
        <label>Peso (kg):
            <input type="number" step="0.1" name="weight" required min="20" max="400">
        </label>
        <label>Altura (cm):
            <input type="number" step="0.1" name="height" required min="80" max="250">
        </label>
        <label>Nível de Atividade:
            <select name="activity">
                <option value="sedentary">Sedentário (pouco ou nenhum exercício)</option>
                <option value="light">Pouca atividade (1-3 dias/semana)</option>
                <option value="moderate">Atividade moderada (3-5 dias/semana)</option>
                <option value="active">Ativo (6-7 dias/semana)</option>
                <option value="very_active">Muito ativo (exercício intenso ou trabalho físico)</option>
            </select>
        </label>
        <label>Objetivo:
            <select name="goal">
                <option value="lose">Perder peso</option>
                <option value="maintain">Manter peso</option>
                <option value="gain">Ganhar peso</option>
            </select>
        </label>
        <input type="submit" value="Calcular">
    </form>
    <?php if ($result): ?>
        <div class="result"><?= $result ?></div>
    <?php endif; ?>
  </main>

  <footer class="main-footer">
    <div class="container footer-flex">
      <div class="footer-brand">
        <img src="logo2.png" alt="Iron Haven Logo">
        <p>Iron Haven &copy; 2025 - Todos os direitos reservados</p>
      </div>
      <div class="footer-links">
        <a href="index.php">Início</a>
        <a href="sobre.html">Sobre</a>
        <a href="planos.html">Planos</a>
        <a href="marcacoes.php">Marcações</a>
        <a href="progresso.php">Progresso</a>
        <a href="login.html">Login</a>
      </div>
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </footer>

  <script>
    const navToggle = document.getElementById('nav-toggle');
    const navLinksLeft = document.querySelector('.nav-left');
    const navLinksRight = document.querySelector('.nav-right');
    if (navToggle) {
      navToggle.onclick = () => {
        navLinksLeft.classList.toggle('open');
        navLinksRight.classList.toggle('open');
      };
    }

    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
      logoutLink.addEventListener('click', function(ev) {
        if (!confirm('Tem a certeza que deseja terminar sessão?')) ev.preventDefault();
      });
    }
  </script>
</body>
</html>