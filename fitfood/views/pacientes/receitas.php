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
        <h1><?= $titulo ?> - <?= htmlspecialchars($paciente->nome) ?></h1>

        <form method="POST" action="<?= base_url('pacientes/receitas/salvar') ?>">
            <input type="hidden" name="paciente_id" value="<?= $paciente->id ?>">
            
            <div class="mb-3">
                <label class="form-label">Selecione as Receitas:</label>
                <?php if ($receitas): ?>
                    <?php foreach($receitas as $receita): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="receitas[]" value="<?= $receita->id ?>" id="receita<?= $receita->id ?>">
                            <label class="form-check-label" for="receita<?= $receita->id ?>">
                                <?= htmlspecialchars($receita->nome) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma receita disponível. <a href="<?= base_url('receitas/novo') ?>">Criar nova receita</a></p>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn" style="background-color: #5cb85c; color: white; border: none;">Atribuir Receitas</button>
            <a href="<?= base_url('pacientes') ?>" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>