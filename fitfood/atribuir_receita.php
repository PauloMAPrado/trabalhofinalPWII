<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

$receitaId = $_GET['receita'] ?? 0;

if ($_POST && isset($_POST['atribuir'])) {
    $pacienteReceitas = new Database('paciente_receitas');
    
    foreach ($_POST['pacientes'] as $pacienteId) {
        $pacienteReceitas->insert([
            'paciente_id' => $pacienteId,
            'refeicao_id' => $receitaId,
            'observacoes' => $_POST['observacoes'] ?? null
        ]);
    }
    
    header('Location: receitas.php?msg=Receita atribuída!');
    exit;
}

$pacientes = new Database('pacientes');
$meusPacientes = $pacientes->select('nutricionista_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);

$refeicoes = new Database('refeicoes');
$receita = $refeicoes->select('id = ?', [$receitaId])->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Atribuir Receita</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="receitas.php" class="navbar-brand">FitFood</a>
            <a href="logout.php" class="btn btn-light">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Atribuir Receita: <?= htmlspecialchars($receita->nome) ?></h1>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Selecione os Pacientes:</label>
                <?php foreach($meusPacientes as $paciente): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pacientes[]" value="<?= $paciente->id ?>" id="pac<?= $paciente->id ?>">
                        <label class="form-check-label" for="pac<?= $paciente->id ?>">
                            <?= htmlspecialchars($paciente->nome) ?> (<?= $paciente->email ?>)
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
            </div>
            
            <button type="submit" name="atribuir" class="btn" style="background-color: #5cb85c; color: white;">Atribuir</button>
            <a href="receitas.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>