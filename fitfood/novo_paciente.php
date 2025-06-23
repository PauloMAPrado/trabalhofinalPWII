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
    
    header('Location: dashboard.php?msg=Paciente cadastrado! Chave: ' . $chave);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Novo Paciente</title>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Cadastrar Novo Paciente</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="cadastrar" class="btn" style="background-color: #5cb85c; color: white;">Cadastrar Paciente</button>
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