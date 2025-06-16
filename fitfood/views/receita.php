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
    <title>FitFood | Receita</title>
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

    <div class="content">

        <div class="containerReceita">

            <img src="../public/img/frangoassado.jpg" alt="" class="imgReceita">

            <h1 class="title">Nome Receita</h1>

            <div class="caracteristicas">
                <div class="tempoPreparo">
                    <h4>Tempo de Preparo</h4>
                    <span class="icon-time"></span>
                    <span class="tempo">30 min</span>
                </div>
                <div class="infoNutri">
                    <h4>Informações Nutricionais</h4>
                    <span class="icon-nutrition"></span>
                    <span class="nutrientes">Proteínas: 10 g</span>
                    <br>
                    <span class="nutrientes">Carboidratos: 30 g</span>
                    <br>
                    <span class="nutrientes">Gorduras: 5 g</span>
                </div>
                <div class="porcoes">
                    <h4>Porções</h4>
                    <span class="icon-portion"></span>
                    <span class="porcao">4 porções</span>
                </div>
            </div>

            <h3 class="ingredientes"> Ingredientes: </h3>
            <ul class="listaIngredientes">
                <li>Ingrediente 1</li>
                <li>Ingrediente 2</li>
                <li>Ingrediente 3</li>
                <li>Ingrediente 4</li>
                <li>Ingrediente 5</li>
            </ul>

            <h3 class="modoPreparo"> Modo de Preparo: </h3>
            <p class="textoPreparo">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            <div class="buttons">
                <button class="btn btn-secondary" id="botaoCurtir">Curtir</button>
                <button class="btn btn-secondary" id="botaoSalvar">Salvar</button>
            </div>

        </div>

    </div>
    
    <footer class="footer">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>
</body>
</html>