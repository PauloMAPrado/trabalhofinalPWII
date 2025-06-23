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
    
    // Criar alimentos dinamicamente
    if (!empty($_POST['nomes_alimentos'])) {
        $alimentos = new Database('alimentos');
        $refeicaoAlimentos = new Database('refeicao_alimentos');
        
        foreach ($_POST['nomes_alimentos'] as $index => $nomeAlimento) {
            if (!empty($nomeAlimento) && !empty($_POST['quantidades'][$index])) {
                // Criar ou buscar alimento
                $alimentoExistente = $alimentos->select('nome = ?', [$nomeAlimento])->fetch(PDO::FETCH_OBJ);
                
                if ($alimentoExistente) {
                    $alimentoId = $alimentoExistente->id;
                } else {
                    $alimentoId = $alimentos->insert([
                        'nome' => $nomeAlimento,
                        'calorias' => $_POST['calorias'][$index] ?? 0,
                        'proteinas' => $_POST['proteinas'][$index] ?? 0,
                        'carboidratos' => $_POST['carboidratos'][$index] ?? 0,
                        'gorduras' => $_POST['gorduras'][$index] ?? 0,
                        'fibras' => $_POST['fibras'][$index] ?? 0,
                        'sodio' => $_POST['sodio'][$index] ?? 0
                    ]);
                }
                
                $refeicaoAlimentos->insert([
                    'refeicao_id' => $refeicaoId,
                    'alimento_id' => $alimentoId,
                    'quantidade_gramas' => $_POST['quantidades'][$index]
                ]);
            }
        }
    }
    
    $sucesso = "Receita criada com sucesso!";
}

$tipos = new Database('tipos_refeicao');
$tiposRefeicao = $tipos->select()->fetchAll(PDO::FETCH_OBJ);

// Não precisamos mais buscar alimentos existentes

$refeicoes = new Database('refeicoes');
$minhasReceitas = $refeicoes->select('nutricionista_criador_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Receitas</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <script src="public/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">← FitFood</a>
            
            <div class="navbar-nav me-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        ➕ Cadastrar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="novo_paciente.php">👥 Novo Paciente</a></li>
                        <li><a class="dropdown-item" href="nova_receita.php">🍽️ Nova Receita</a></li>
                    </ul>
                </div>
                <a class="nav-link" href="pacientes.php">👥 Pacientes</a>
            </div>
            
            <a href="logout.php" class="btn btn-light btn-sm">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Minhas Receitas</h1>
        
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success"><?= $sucesso ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <h3>Criar Receita</h3>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nome da Receita" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="tipo_refeicao_id" required>
                            <option value="">Tipo de Refeição</option>
                            <?php foreach($tiposRefeicao as $tipo): ?>
                                <option value="<?= $tipo->id ?>"><?= htmlspecialchars($tipo->nome) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <h5>Alimentos da Receita</h5>
                    <div id="alimentos-container">
                        <div class="alimento-row border p-3 mb-3">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Nome do Alimento" name="nomes_alimentos[]" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Quantidade (g)" name="quantidades[]" step="0.1" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Calorias/100g" name="calorias[]" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeAlimento(this)">X</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Proteínas/100g" name="proteinas[]" step="0.01">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Carboidratos/100g" name="carboidratos[]" step="0.01">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Gorduras/100g" name="gorduras[]" step="0.01">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Fibras/100g" name="fibras[]" step="0.01">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <input type="number" class="form-control" placeholder="Sódio/100g" name="sodio[]" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary mb-3" onclick="addAlimento()">+ Alimento</button>
                    <br>
                    <button type="submit" name="criar" class="btn" style="background-color: #5cb85c; color: white;">Criar Receita</button>
                </form>
            </div>
            
            <div class="col-md-4">
                <h3>Minhas Receitas</h3>
                <div class="list-group">
                    <?php foreach($minhasReceitas as $receita): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($receita->nome) ?></span>
                                <div>
                                    <a href="ver_receita.php?id=<?= $receita->id ?>" class="btn btn-sm btn-info">Ver</a>
                                    <a href="atribuir_receita.php?receita=<?= $receita->id ?>" class="btn btn-sm" style="background-color: #28a745; color: white;">Atribuir</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <script>
        function addAlimento() {
            const container = document.getElementById('alimentos-container');
            const newRow = container.querySelector('.alimento-row').cloneNode(true);
            newRow.querySelectorAll('select, input').forEach(el => el.value = '');
            container.appendChild(newRow);
        }
        
        function removeAlimento(btn) {
            const container = document.getElementById('alimentos-container');
            if (container.children.length > 1) {
                btn.closest('.alimento-row').remove();
            }
        }
        </script>
    </div>
</body>
</html>