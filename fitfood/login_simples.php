<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if ($_POST) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Tenta nutricionista
    $nutri = new Database('nutricionistas');
    $user = $nutri->select('email = ?', [$email])->fetch(PDO::FETCH_OBJ);
    
    if ($user && password_verify($senha, $user->senha)) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_nome'] = $user->nome;
        $_SESSION['user_tipo'] = 'nutricionista';
        header('Location: dashboard.php');
        exit;
    }
    
    // Tenta paciente
    $pac = new Database('pacientes');
    $user = $pac->select('email = ? AND chave_acesso = ?', [$email, $senha])->fetch(PDO::FETCH_OBJ);
    
    if ($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_nome'] = $user->nome;
        $_SESSION['user_tipo'] = 'paciente';
        header('Location: cronograma_simples.php');
        exit;
    }
    
    $erro = "Login inválido!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FitFood - Login</title>
    <link rel="stylesheet" href="public/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/style/style.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="loginBox">
        <h1 class="loginTitle">FitFood | Login</h1>
        
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="textbox">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>
            <div class="textbox">
                <input type="password" class="form-control" placeholder="Senha ou Chave" name="senha" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>
        <a href="cadastro_simples.php">Criar conta</a>
    </div>
</body>
</html>