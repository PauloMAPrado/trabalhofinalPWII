<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('public/style/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
    <title>FitFood | Cronograma</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="<?= base_url('public/img/logo.jpg') ?>" alt="Logo FitFood">
        </div>
        <nav class="navbar">
            <a href="<?= base_url('/') ?>">Home</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= base_url('logout') ?>">Sair</a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container mt-4">
        <h3>Cronograma de Refeições</h3>
        
        <div class="row mt-4">
            <?php 
            $refeicoes = ['Café da Manhã', 'Colação', 'Almoço', 'Lanche', 'Jantar', 'Ceia'];
            foreach($refeicoes as $refeicao): 
            ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $refeicao ?></h5>
                        <a href="<?= base_url('/') ?>" class="btn" style="background-color: #5cb85c; color: white; border: none;">Ver Receitas</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>
</body>
</html>