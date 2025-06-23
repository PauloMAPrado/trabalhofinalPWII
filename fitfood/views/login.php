<?php
if (isset($_SESSION['user_id'])) {
    header('Location: ' . base_url('/'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | Login</title>
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/style/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('public/img/logo.jpg') ?>" type="image/x-icon">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="loginBox">
        <h1 class="loginTitle">FitFood | Login</h1>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg']['color'] ?>">
                <?= htmlspecialchars($_SESSION['msg']['texto']) ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <form action="/login/auth" method="POST">
            <div class="textbox">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
            </div>
            <div class="textbox">
                <input type="password" class="form-control" placeholder="Senha (Nutricionista) ou Chave de Acesso (Paciente)" name="senha" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
        </form>
        <a href="<?= base_url('cadastro') ?>">Criar conta</a>
    </div>
</body>
</html>