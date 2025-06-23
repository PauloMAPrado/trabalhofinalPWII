<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a class="navbar-brand" href="#">FitFood</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Olá, <?= htmlspecialchars($usuario) ?>!</span>
                <a class="nav-link" href="<?= base_url('logout') ?>">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Dashboard do Nutricionista</h1>
        
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg']['color'] ?>">
                <?= $_SESSION['msg']['texto'] ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pacientes</h5>
                        <p class="card-text">Gerencie seus pacientes</p>
                        <a href="<?= base_url('pacientes') ?>" class="btn" style="background-color: #5cb85c; color: white; border: none;">Ver Pacientes</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Receitas</h5>
                        <p class="card-text">Crie e gerencie receitas</p>
                        <a href="<?= base_url('receitas/novo') ?>" class="btn" style="background-color: #5cb85c; color: white; border: none;">Nova Receita</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Meu Perfil</h5>
                        <p class="card-text">Atualize suas informações</p>
                        <a href="<?= base_url('nutricionista/perfil') ?>" class="btn" style="background-color: #5cb85c; color: white; border: none;">Ver Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>