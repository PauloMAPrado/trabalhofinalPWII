<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

if ($_POST && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $chave = strtoupper(substr($nome, 0, 3)) . rand(100, 999);
    
    $pac = new Database('pacientes');
    $pac->insert([
        'nutricionista_id' => $_SESSION['user_id'],
        'nome' => $nome,
        'email' => $email,
        'chave_acesso' => $chave,
        'data_nascimento' => $_POST['data_nascimento']
    ]);
    
    $sucesso = "Paciente cadastrado! Chave: $chave";
}

$pac = new Database('pacientes');
$pacientes = $pac->select('nutricionista_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pacientes</title>
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
                        <li><a class="dropdown-item" href="receitas.php">📋 Receita Completa</a></li>
                    </ul>
                </div>
                <a class="nav-link" href="pacientes.php">👥 Pacientes</a>
                <a class="nav-link" href="receitas.php">🍽️ Receitas</a>
            </div>
            
            <a href="logout.php" class="btn btn-light btn-sm">Sair</a>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Meus Pacientes</h1>
        
        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success"><?= $sucesso ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Cadastrar Paciente</h3>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <input type="date" class="form-control" name="data_nascimento">
                    </div>
                    <button type="submit" name="cadastrar" class="btn" style="background-color: #5cb85c; color: white;">Cadastrar</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h3>Lista de Pacientes</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Chave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pacientes as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->nome) ?></td>
                                <td><?= htmlspecialchars($p->email) ?></td>
                                <td><strong><?= $p->chave_acesso ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>