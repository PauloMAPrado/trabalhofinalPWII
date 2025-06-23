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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= $titulo ?></h1>
            <a href="<?= base_url('pacientes/novo') ?>" class="btn" style="background-color: #5cb85c; color: white; border: none;">Novo Paciente</a>
        </div>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-<?= $_SESSION['msg']['color'] ?>">
                <?= $_SESSION['msg']['texto'] ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data Nascimento</th>
                        <th>Chave Acesso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pacientes): ?>
                        <?php foreach($pacientes as $paciente): ?>
                            <tr>
                                <td><?= htmlspecialchars($paciente->nome) ?></td>
                                <td><?= htmlspecialchars($paciente->email) ?></td>
                                <td><?= $paciente->data_nascimento ? date('d/m/Y', strtotime($paciente->data_nascimento)) : '-' ?></td>
                                <td><strong><?= htmlspecialchars($paciente->chave_acesso ?? 'N/A') ?></strong></td>
                                <td>
                                    <a href="<?= base_url('pacientes/editar/' . $paciente->id) ?>" class="btn btn-sm" style="background-color: #5cb85c; color: white;">Editar</a>
                                    <a href="<?= base_url('pacientes/receitas/' . $paciente->id) ?>" class="btn btn-sm" style="background-color: #28a745; color: white;">Receitas</a>
                                    <form method="POST" action="<?= base_url('pacientes/deletar') ?>" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $paciente->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum paciente cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>