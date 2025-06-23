<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

$receitaId = $_GET['id'] ?? 0;

// Buscar receita
$refeicoes = new Database('refeicoes');
$receita = $refeicoes->select('id = ? AND nutricionista_criador_id = ?', [$receitaId, $_SESSION['user_id']])->fetch(PDO::FETCH_OBJ);

if (!$receita) {
    header('Location: receitas.php');
    exit;
}

if ($_POST && isset($_POST['atualizar'])) {
    $refeicoes->update('id = ?', [$receitaId], [
        'nome' => $_POST['nome'],
        'tipo_refeicao_id' => $_POST['tipo_refeicao_id']
    ]);
    
    header('Location: receitas.php?msg=Receita atualizada!');
    exit;
}

$tipos = new Database('tipos_refeicao');
$tiposRefeicao = $tipos->select()->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Receita</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="receitas.php" class="navbar-brand">← Voltar às Receitas</a>
            <a href="logout.php" class="btn btn-light btn-sm">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Editar Receita</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome da Receita</label>
                                <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($receita->nome) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo de Refeição</label>
                                <select class="form-control" name="tipo_refeicao_id" required>
                                    <?php foreach($tiposRefeicao as $tipo): ?>
                                        <option value="<?= $tipo->id ?>" <?= $tipo->id == $receita->tipo_refeicao_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tipo->nome) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="atualizar" class="btn" style="background-color: #5cb85c; color: white;">Atualizar Receita</button>
                                <a href="receitas.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>