<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | Meu Perfil</title>
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5cb85c;">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('nutricionista/dashboard') ?>">FitFood</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?= base_url('logout') ?>">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Meu Perfil</h1>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg']['color'] ?>">
                <?= $_SESSION['msg']['texto'] ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('nutricionista/perfil/save') ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nutricionista->nome) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="crn" class="form-label">CRN</label>
                        <input type="text" class="form-control" id="crn" name="crn" value="<?= htmlspecialchars($nutricionista->crn ?? '') ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($nutricionista->email) ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($nutricionista->telefone ?? '') ?>">
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn" style="background-color: #5cb85c; color: white; border: none;">Salvar Alterações</button>
            <a href="<?= base_url('nutricionista/dashboard') ?>" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>