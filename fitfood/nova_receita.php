<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

if ($_POST && isset($_POST['criar'])) {
    $refeicoes = new Database('refeicoes');
    $refeicaoId = $refeicoes->insert([
        'nome' => $_POST['nome'],
        'tipo_refeicao_id' => $_POST['tipo_refeicao_id'],
        'nutricionista_criador_id' => $_SESSION['user_id']
    ]);
    
    header('Location: dashboard.php?msg=Receita criada com sucesso!');
    exit;
}

$tipos = new Database('tipos_refeicao');
$tiposRefeicao = $tipos->select()->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nova Receita</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← Voltar ao Dashboard</a>
            <a href="logout.php" class="btn btn-light btn-sm">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Criar Nova Receita</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome da Receita</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo de Refeição</label>
                                <select class="form-control" name="tipo_refeicao_id" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($tiposRefeicao as $tipo): ?>
                                        <option value="<?= $tipo->id ?>"><?= htmlspecialchars($tipo->nome) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="criar" class="btn" style="background-color: #5cb85c; color: white;">Criar Receita</button>
                                <a href="receitas.php" class="btn btn-info">Criar Receita Completa (com alimentos)</a>
                                <a href="dashboard.php" class="btn btn-secondary">Voltar ao Dashboard</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>