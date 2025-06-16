<?php

session_start();

require_once(__DIR__ . "/../fitfood/Models/Database.php"); 

use Models\Database;

$mensagem_erro = '';

if (isset($_GET['erro']) && $_GET['erro'] == 1) {
    $mensagem_erro = "Email ou senha incorretos. Tente novamente.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'] ?? null;
    $senha = $_POST['senha'] ?? null;

    if (empty($email) || empty($senha)) {
        $mensagem_erro = "Por favor, preencha todos os campos.";
    } else {
        $db_nutri = new Database('nutricionistas');
        $nutricionista = $db_nutri->select('email = :email', [':email' => $email])->fetch(PDO::FETCH_OBJ);

        if ($nutricionista && password_verify($senha, $nutricionista->senha)) {
            // LOGIN BEM-SUCEDIDO COMO NUTRICIONISTA
            $_SESSION['nutri_id'] = $nutricionista->id;
            $_SESSION['user_nome'] = $nutricionista->nome;
            $_SESSION['user_tipo'] = 'nutricionista';
            
            // Redireciona para o painel do nutricionista
            header("Location: /fitfood/views/perfil.php"); 
            exit();
        }

        // Se não era um nutricionista, tenta encontrar na tabela de pacientes
        $pacientes = new Database('pacientes');
        $pacientes = $pacientes->select('email = :email', [':email' => $email])->fetch(PDO::FETCH_OBJ);
        
        // Verifica se encontrou um paciente e se a senha está correta
        if ($paciente && password_verify($senha, $paciente->senha)) {
            // LOGIN BEM-SUCEDIDO COMO PACIENTE
            $_SESSION['paciente_id'] = $pacientes->id;
            $_SESSION['user_nome'] = $pacientes->nome;
            $_SESSION['user_tipo'] = 'paciente';
            
            // Redireciona para o painel do paciente
            header("Location: /fitfood/views/cronograma.php"); 
            exit();
        }

    
        header("Location: login.php?erro=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fitfood/public/style/style.css">
    <link rel="shortcut icon" href="../fitfood/public/img/logo.jpg" type="image/x-icon">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="loginBox">
        <h1 class="loginTitle">FitFood | Login</h1>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($mensagem_erro) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="textbox">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>
            <div class="textbox">
                <input type="password" class="form-control" placeholder="Senha" name="senha" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>
        <a href="../fitfood/views/cadastro.php">Criar conta</a>
    </div>
</body>
</html>