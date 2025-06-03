<?php
include '../controller/conexao.php';

// Definir a consulta SQL
$sql = "SELECT id, titulo, descricao, imagem_url FROM receitas ORDER BY id DESC";

// Executar a consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="shortcut icon" href="../public/img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <title>FitFood | Home</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../public/img/logo.jpg" alt="Logo FitFood">
        </div>
        <nav class="navbar">
            <a href="">Home</a>
            <a href="">Cronograma</a>
            <a href="">Perfil</a>
        </nav>
    </header>

    <div class="content">
        <h1 class="title">
            <b>
                <i>Bom Apetite</i>
            </b>
        </h1>
        <p class="subtitle">Descubra receitas saudáveis e deliciosas</p>

        <div class="cardReceita">

            <?php
            // Checar se existem resultados
            if ($result && $result->num_rows > 0) {
                // Iterar sobre cada linha (receita)
                while($row = $result->fetch_assoc()) {
                    // --- Início do Card Dinâmico ---
                    echo '<div class="card">';
                    echo '    <div class="card-body">';
                    
                    // Imagem da Receita (Usa imagem padrão se não houver)
                    // ATENÇÃO: Verifique o caminho da imagem padrão
                    $imagem = !empty($row["imagem_url"]) ? $row["imagem_url"] : '../public/img/default_recipe.jpg';
                    echo '        <img src="' . htmlspecialchars($imagem) . '" alt="' . htmlspecialchars($row["titulo"]) . '" class="card-img">';
                    
                    echo '        <div class="text">';
                    // Título da Receita
                    echo '            <h5 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h5>';
                    // Descrição da Receita (pode limitar o tamanho se quiser)
                    echo '            <p class="card-text">' . htmlspecialchars($row["descricao"]) . '</p>';
                    echo '        </div>';
                    
                    // Botão Ver Receita (Link para pagina_receita.php com o ID)
                    echo '        <a href="pagina_receita.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Receita</a>';
                    
                    // Botão Curtir (Sem ID, com data-id para JavaScript)
                    echo '        <button class="btn btn-secondary like-button" data-id="' . $row["id"] . '">';
                    echo '        </button>';
                    
                    echo '    </div>';
                    echo '</div>';
                    // --- Fim do Card Dinâmico ---
                }
            } else {
                // Mensagem se não houver receitas
                echo "<p style='text-align: center; font-size: 1.1em; margin: 40px;'>Nenhuma receita encontrada no momento. Volte em breve!</p>";
            }
            ?>

        </div> </div> <footer class="footer">
        <p>&copy; 2025 FitFood. Todos os direitos reservados.</p>
    </footer>

    <?php
    // Fechar a conexão com o banco de dados
    $conn->close();
    ?>

    <script>
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', function() {
                const receitaId = this.getAttribute('data-id');
                console.log('Clicou em curtir na receita ID: ' + receitaId);
                // Implemente a lógica AJAX aqui para curtir sem recarregar
            });
        });
    </script>

</body>
</html>