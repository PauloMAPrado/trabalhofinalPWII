<?php
session_start();
if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <script src="public/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">FitFood</a>
            
            <div class="navbar-nav me-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        ➕ Cadastrar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="novo_paciente.php">👥 Novo Paciente</a></li>
                        <li><a class="dropdown-item" href="nova_receita.php">🍽️ Nova Receita</a></li>
                        <li><a class="dropdown-item" href="receitas.php">📋 Receita Completa</a></li>
                    </ul>
                </div>
                <a class="nav-link" href="pacientes.php">👥 Pacientes</a>
                <a class="nav-link" href="receitas.php">🍽️ Receitas</a>
                <a class="nav-link" href="relatorios.php">📊 Relatórios</a>
            </div>
            
            <div class="navbar-nav">
                <span class="navbar-text me-3">Olá, <?= $_SESSION['user_nome'] ?>!</span>
                <a href="logout.php" class="btn btn-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Dashboard Nutricionista</h1>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['msg']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>👥 Pacientes</h5>
                        <p>Gerencie seus pacientes</p>
                        <a href="pacientes.php" class="btn mb-2" style="background-color: #5cb85c; color: white; width: 100%;">Ver Todos</a>
                        <a href="novo_paciente.php" class="btn btn-outline-success" style="width: 100%;">Cadastrar Novo</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>🍽️ Receitas</h5>
                        <p>Crie e gerencie receitas</p>
                        <a href="receitas.php" class="btn mb-2" style="background-color: #5cb85c; color: white; width: 100%;">Ver Todas</a>
                        <a href="nova_receita.php" class="btn btn-outline-success" style="width: 100%;">Criar Nova</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>📊 Relatórios</h5>
                        <p>Acompanhe o progresso</p>
                        <a href="relatorios.php" class="btn" style="background-color: #5cb85c; color: white; width: 100%;">Ver Relatórios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>