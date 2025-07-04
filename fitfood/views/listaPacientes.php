<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="shortcut icon" href="../public/img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>FitFood | Perfil</title>
</head>
<body>
    
    <header class="header">
        <div class="logo">
            <img src="../public/img/logo.jpg" alt="Logo FitFood">
        </div>
        <nav class="navbar">
            <a href="../views/home.php">Home</a>
            <a href="../views/cronograma.php">Cronograma</a>
            <a href="../views/perfil.php">Perfil</a>
            <a href="../views/cadUser.php">Cadastrar Usuário</a>
        </nav>
    </header>

    <div class="contentListaPacientes">
        <h1 class="title">Meus Pacientes</h1>
        <div class="pacientesList">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Endereço</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemplo de paciente -->
                    <tr>
                        <td>João da Silva</td>
                        <td>(11) 98765-4321</td>
                        <td>joaosilva@gmail.com</td>
                        <td>Rua Exemplo, 123</td>
                    </tr>
                    <tr>
                        <td>Maria Oliveira</td>
                        <td>(21) 91234-5678</td>
                        <td>mariaoliveira@gmail.com</td>
                        <td>Avenida Teste, 456</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="cadastroPaciente">
        <a href="../views/cadUser.php" class="btn btn-secondary" id="cadPaciente">Cadastrar Paciente</a>
    </div>

</body>
</html>