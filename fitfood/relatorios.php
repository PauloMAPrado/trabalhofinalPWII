<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

$pacientes = new Database('pacientes');
$totalPacientes = $pacientes->select('nutricionista_id = ?', [$_SESSION['user_id']])->rowCount();

$refeicoes = new Database('refeicoes');
$totalReceitas = $refeicoes->select('nutricionista_criador_id = ?', [$_SESSION['user_id']])->rowCount();

$pacienteReceitas = new Database('paciente_receitas');
$totalAtribuicoes = $pacienteReceitas->select('pr.paciente_id IN (SELECT id FROM pacientes WHERE nutricionista_id = ?)', [$_SESSION['user_id']])->rowCount();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Relatórios</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">FitFood</a>
            <a href="logout.php" class="btn btn-light">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Relatórios</h1>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="text-primary"><?= $totalPacientes ?></h2>
                        <h5>Pacientes Cadastrados</h5>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="text-success"><?= $totalReceitas ?></h2>
                        <h5>Receitas Criadas</h5>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="text-info"><?= $totalAtribuicoes ?></h2>
                        <h5>Receitas Atribuídas</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Voltar ao Dashboard</a>
        </div>
    </div>
</body>
</html>