<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

$receitaId = $_GET['id'] ?? 0;

$refeicoes = new Database('refeicoes');
$receita = $refeicoes->select('id = ?', [$receitaId])->fetch(PDO::FETCH_OBJ);

if (!$receita) {
    header('Location: receitas.php');
    exit;
}

// Buscar alimentos da receita
$refeicaoAlimentos = new Database('refeicao_alimentos');
$ingredientes = $refeicaoAlimentos->select('refeicao_id = ?', [$receitaId])->fetchAll(PDO::FETCH_OBJ);

$totalCalorias = 0;
$totalProteinas = 0;
$totalCarboidratos = 0;
$totalGorduras = 0;

$alimentos = new Database('alimentos');
$detalhesIngredientes = [];

foreach($ingredientes as $ing) {
    $alimento = $alimentos->select('id = ?', [$ing->alimento_id])->fetch(PDO::FETCH_OBJ);
    if ($alimento) {
        $fator = $ing->quantidade_gramas / 100; // Converter para porção
        
        $detalhesIngredientes[] = [
            'nome' => $alimento->nome,
            'quantidade' => $ing->quantidade_gramas,
            'calorias' => $alimento->calorias * $fator,
            'proteinas' => $alimento->proteinas * $fator,
            'carboidratos' => $alimento->carboidratos * $fator,
            'gorduras' => $alimento->gorduras * $fator
        ];
        
        $totalCalorias += $alimento->calorias * $fator;
        $totalProteinas += $alimento->proteinas * $fator;
        $totalCarboidratos += $alimento->carboidratos * $fator;
        $totalGorduras += $alimento->gorduras * $fator;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Receita</title>
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
        <h1><?= htmlspecialchars($receita->nome) ?></h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Ingredientes</h3>
                <ul class="list-group">
                    <?php foreach($detalhesIngredientes as $ing): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?= htmlspecialchars($ing['nome']) ?></span>
                            <span><?= $ing['quantidade'] ?>g</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="col-md-6">
                <h3>Informações Nutricionais (Total)</h3>
                <div class="card">
                    <div class="card-body">
                        <p><strong>Calorias:</strong> <?= number_format($totalCalorias, 1) ?> kcal</p>
                        <p><strong>Proteínas:</strong> <?= number_format($totalProteinas, 1) ?>g</p>
                        <p><strong>Carboidratos:</strong> <?= number_format($totalCarboidratos, 1) ?>g</p>
                        <p><strong>Gorduras:</strong> <?= number_format($totalGorduras, 1) ?>g</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="receitas.php" class="btn btn-secondary">Voltar</a>
            <a href="atribuir_receita.php?receita=<?= $receita->id ?>" class="btn" style="background-color: #5cb85c; color: white;">Atribuir aos Pacientes</a>
        </div>
    </div>
</body>
</html>