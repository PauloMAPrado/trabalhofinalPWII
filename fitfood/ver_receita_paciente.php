<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'paciente') {
    header('Location: login_simples.php');
    exit;
}

$receitaId = $_GET['id'] ?? 0;

// Buscar receita
$refeicoes = new Database('refeicoes');
$receita = $refeicoes->select('id = ?', [$receitaId])->fetch(PDO::FETCH_OBJ);

if (!$receita) {
    header('Location: cronograma_simples.php');
    exit;
}

// Buscar tipo de refeição
$tipos = new Database('tipos_refeicao');
$tipoRefeicao = $tipos->select('id = ?', [$receita->tipo_refeicao_id])->fetch(PDO::FETCH_OBJ);

// Buscar alimentos da receita
$refeicaoAlimentos = new Database('refeicao_alimentos');
$ingredientes = $refeicaoAlimentos->select('refeicao_id = ?', [$receitaId])->fetchAll(PDO::FETCH_OBJ);

$totalCalorias = 0;
$totalProteinas = 0;
$totalCarboidratos = 0;
$totalGorduras = 0;
$totalFibras = 0;
$totalSodio = 0;

$alimentos = new Database('alimentos');
$detalhesIngredientes = [];

foreach($ingredientes as $ing) {
    $alimento = $alimentos->select('id = ?', [$ing->alimento_id])->fetch(PDO::FETCH_OBJ);
    if ($alimento) {
        $fator = $ing->quantidade_gramas / 100;
        
        $detalhesIngredientes[] = [
            'nome' => $alimento->nome,
            'quantidade' => $ing->quantidade_gramas,
            'calorias' => $alimento->calorias * $fator,
            'proteinas' => $alimento->proteinas * $fator,
            'carboidratos' => $alimento->carboidratos * $fator,
            'gorduras' => $alimento->gorduras * $fator,
            'fibras' => $alimento->fibras * $fator,
            'sodio' => $alimento->sodio * $fator
        ];
        
        $totalCalorias += $alimento->calorias * $fator;
        $totalProteinas += $alimento->proteinas * $fator;
        $totalCarboidratos += $alimento->carboidratos * $fator;
        $totalGorduras += $alimento->gorduras * $fator;
        $totalFibras += $alimento->fibras * $fator;
        $totalSodio += $alimento->sodio * $fator;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Minha Receita</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= htmlspecialchars($receita->nome) ?></h1>
            <button onclick="window.print()" class="btn" style="background-color: #5cb85c; color: white;">🖨️ Imprimir</button>
        </div>
        
        <div class="alert alert-info">
            <strong>Tipo de Refeição:</strong> <?= htmlspecialchars($tipoRefeicao->nome ?? 'Não definido') ?>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>📋 Ingredientes</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($detalhesIngredientes): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach($detalhesIngredientes as $ing): ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><?= htmlspecialchars($ing['nome']) ?></span>
                                        <strong><?= $ing['quantidade'] ?>g</strong>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Nenhum ingrediente cadastrado para esta receita.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>📊 Informações Nutricionais</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border p-2 rounded">
                                    <h5 class="text-primary"><?= number_format($totalCalorias, 0) ?></h5>
                                    <small>Calorias (kcal)</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border p-2 rounded">
                                    <h5 class="text-success"><?= number_format($totalProteinas, 1) ?>g</h5>
                                    <small>Proteínas</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border p-2 rounded">
                                    <h5 class="text-warning"><?= number_format($totalCarboidratos, 1) ?>g</h5>
                                    <small>Carboidratos</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border p-2 rounded">
                                    <h5 class="text-danger"><?= number_format($totalGorduras, 1) ?>g</h5>
                                    <small>Gorduras</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border p-2 rounded">
                                    <h5 class="text-info"><?= number_format($totalFibras, 1) ?>g</h5>
                                    <small>Fibras</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border p-2 rounded">
                                    <h5 class="text-secondary"><?= number_format($totalSodio, 1) ?>mg</h5>
                                    <small>Sódio</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <a href="cronograma_simples.php" class="btn btn-secondary">← Voltar às Minhas Receitas</a>
        </div>
    </div>
    
    <footer class="footer mt-5">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>
    
    <style>
        @media print {
            .btn, .footer, header .navbar a[href*="logout"] { display: none !important; }
            body { font-size: 12px; }
        }
    </style>
</body>
</html>