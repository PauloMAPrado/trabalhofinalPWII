<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | <?= $titulo ?></title>
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
        <h1><?= $titulo ?></h1>

        <form method="POST" action="<?= base_url('receitas/salvar') ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Receita</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            
            <div class="mb-3">
                <label for="tipo_refeicao_id" class="form-label">Tipo de Refeição</label>
                <select class="form-control" id="tipo_refeicao_id" name="tipo_refeicao_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach($tipos_refeicao as $tipo): ?>
                        <option value="<?= $tipo->id ?>"><?= htmlspecialchars($tipo->nome) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="btn" style="background-color: #5cb85c; color: white; border: none;">Salvar</button>
            <a href="<?= base_url('nutricionista/dashboard') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>