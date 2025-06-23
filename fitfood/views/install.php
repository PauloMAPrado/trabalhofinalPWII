<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>FitFood - Instalação</title>
    <link rel="stylesheet" href="<?= base_url('public/bootstrap-5.3.5-dist/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Instalação do FitFood</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_POST['install'])) {
                            try {
                                $pdo = new PDO('mysql:host=mysql;port=3306;charset=utf8', 'aluno', '123456');
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                
                                $sql = file_get_contents(__DIR__ . '/../Database/fitfood.sql');
                                $pdo->exec($sql);
                                
                                echo '<div class="alert alert-success">Banco instalado com sucesso!</div>';
                                echo '<a href="http://localhost:8050/" class="btn" style="background-color: #5cb85c; color: white; border: none; text-decoration: none;">Ir para Login</a>';
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">Erro: ' . $e->getMessage() . '</div>';
                            }
                        } else {
                        ?>
                            <p>Clique no botão abaixo para instalar o banco de dados:</p>
                            <form method="POST">
                                <button type="submit" name="install" class="btn" style="background-color: #5cb85c; color: white; border: none;">Instalar Banco</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>