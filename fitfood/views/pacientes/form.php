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

        <form method="POST" action="<?= isset($paciente) ? base_url('pacientes/editar/save') : base_url('pacientes/salvar') ?>">
            <?php if (isset($paciente)): ?>
                <input type="hidden" name="id" value="<?= $paciente->id ?>">
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($paciente) ? htmlspecialchars($paciente->nome) : '' ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= isset($paciente) ? htmlspecialchars($paciente->email) : '' ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= isset($paciente) ? $paciente->data_nascimento : '' ?>">
            </div>
            
            <?php if (isset($paciente)): ?>
                <div class="mb-3">
                    <label class="form-label">Chave de Acesso</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($paciente->chave_acesso) ?>" readonly>
                </div>
            <?php endif; ?>
            
            <button type="submit" class="btn" style="background-color: #5cb85c; color: white; border: none;">Salvar</button>
            <a href="<?= base_url('pacientes') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>