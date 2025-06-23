<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'paciente') {
    header('Location: login_simples.php');
    exit;
}

$pacienteReceitas = new Database('paciente_receitas');
$minhasReceitas = $pacienteReceitas->select('paciente_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);

// Buscar nomes das receitas
$receitas = [];
foreach($minhasReceitas as $pr) {
    $refeicoes = new Database('refeicoes');
    $receita = $refeicoes->select('id = ?', [$pr->refeicao_id])->fetch(PDO::FETCH_OBJ);
    if ($receita) {
        $receitas[] = [
            'nome' => $receita->nome,
            'observacoes' => $pr->observacoes,
            'refeicao_id' => $pr->refeicao_id
        ];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Meu Cronograma</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/style/style.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="public/img/logo.jpg" alt="Logo FitFood">
        </div>
        <nav class="navbar">
            <span>Olá, <?= $_SESSION['user_nome'] ?>!</span>
            <a href="logout.php">Sair</a>
        </nav>
    </header>
    
    <div class="container mt-4">
        <h1 class="title">Minhas Receitas Personalizadas</h1>
        
        <?php if ($receitas): ?>
            <?php foreach($receitas as $receita): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><?= htmlspecialchars($receita['nome']) ?></h5>
                                <?php if ($receita['observacoes']): ?>
                                    <p class="card-text"><strong>Observações:</strong> <?= htmlspecialchars($receita['observacoes']) ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="ver_receita_paciente.php?id=<?= $receita['refeicao_id'] ?>" class="btn" style="background-color: #5cb85c; color: white;">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                Nenhuma receita foi atribuída pelo seu nutricionista ainda.
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="footer">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>
</body>
</html>