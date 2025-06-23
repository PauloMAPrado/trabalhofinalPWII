<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if ($_POST) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    $nutri = new Database('nutricionistas');
    $nutri->insert([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha,
        'crn' => $_POST['crn'] ?? null,
        'telefone' => $_POST['telefone'] ?? null
    ]);
    
    header('Location: login_simples.php?msg=Cadastro realizado!');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FitFood - Cadastro</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/style/style.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="loginBox">
        <h1 class="loginTitle">FitFood | Cadastro</h1>
        
        <form method="POST">
            <div class="textbox">
                <input type="text" class="form-control" placeholder="Nome" name="nome" required>
            </div>
            <div class="textbox">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>
            <div class="textbox">
                <input type="text" class="form-control" placeholder="CRN" name="crn">
            </div>
            <div class="textbox">
                <input type="text" class="form-control" placeholder="Telefone" name="telefone">
            </div>
            <div class="textbox">
                <input type="password" class="form-control" placeholder="Senha" name="senha" required>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
        <a href="login_simples.php">Já tenho conta</a>
    </div>
</body>
</html>