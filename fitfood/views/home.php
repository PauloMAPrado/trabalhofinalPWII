<?php
if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === 'paciente') {
    require_once(__DIR__ . '/../Database/Database.php');
    use Models\Database;
    
    $pacienteReceitas = new Database('paciente_receitas');
    // Query simples para buscar receitas do paciente
    $minhasReceitas = $pacienteReceitas->select('paciente_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);
} else {
    $minhasReceitas = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('public/style/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('public/img/logo.jpg') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
    <title>FitFood | Home</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="<?= base_url('public/img/logo.jpg') ?>" alt="Logo FitFood">
        </div>
        <nav class="navbar">
            <a href="<?= base_url('/') ?>">Home</a>
            <?php if (isset($_SESSION['user_tipo'])): ?>
                <a href="<?= base_url('logout') ?>">Sair</a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="content">
        <h1 class="title"><b><i>Bom Apetite</i></b></h1>
        <p class="subtitle">Descubra receitas saudáveis e deliciosas</p>

        <?php if (isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === 'paciente'): ?>
            <div class="container mt-4">
                <h3>Suas Receitas Personalizadas</h3>
                <?php if ($minhasReceitas): ?>
                    <?php foreach($minhasReceitas as $receita): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Receita ID: <?= $receita->refeicao_id ?></h5>
                                <?php if ($receita->observacoes): ?>
                                    <p class="card-text"><strong>Observações:</strong> <?= htmlspecialchars($receita->observacoes) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma receita foi atribuída pelo seu nutricionista ainda.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="cardReceita">
                <p>Faça login como paciente para ver suas receitas personalizadas.</p>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>
</body>
</html>