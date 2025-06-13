<?php
// progresso.php - Registo de peso e calculadora de calorias

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
<html>
<head>
<title>Acompanhamento de Progresso</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: auto; padding: 20px; }
        h2 { color: #197278; }
        form { background: #f5f5f5; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        .result { margin-top: 15px; font-size: 1.2em; color: #197278; }
        .message { color: #006400; }
    </style>
</head>
<body>
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
</body>
</html>