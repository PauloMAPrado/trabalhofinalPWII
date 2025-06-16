<?php

session_start();
if (!isset($_SESSION['nutricionista_id'])) { header("Location: login.php"); exit(); }

?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitFood | Cadastrar Receita</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="shortcut icon" href="../public/img/logo.jpg" type="image/x-icon">
</head>

<body id="cadastro">
    <div class="cadastroBox" style="width: 800px; max-width: 95%;">
        <h1 class="cadastroTitle">Cadastro de Receita</h1>

        <form action="<?= base_url('receitas/salvar') // Rota de destino no seu router ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto da Receita</label>
                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Receita</label>
                        <input type="text" class="form-control" placeholder="Ex: Salmão Grelhado com Legumes" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="detalhes" class="form-label">Descrição Curta</label>
                        <input type="text" class="form-control" placeholder="Ex: Um prato leve e nutritivo..." id="detalhes" name="detalhes" required>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="mb-3">
                        <label for="categoria" class="form-label">Tipo de Refeição</label>
                        <select class="form-select" name="tipo_refeicao_id" id="categoria" required>
                            <option value="" disabled selected>Selecione um tipo...</option>
                            <option value="1">Café da manhã</option>
                            <option value="2">Colação</option>
                            <option value="3">Almoço</option>
                            <option value="4">Lanche</option>
                            <option value="5">Jantar</option>
                            <option value="6">Ceia</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                             <div class="mb-3">
                                <label for="tempoPreparo" class="form-label">Tempo de Preparo</label>
                                <input type="number" class="form-control" placeholder="minutos" id="tempoPreparo" name="tempoPreparo" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="porcoes" class="form-label">Rendimento (porções)</label>
                                <input type="number" class="form-control" placeholder="Ex: 2" id="porcoes" name="porcoes" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="mt-4">Ingredientes</h5>
            <div id="ingredientes-container">
                <div class="row mb-2 align-items-center ingrediente-row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="ingrediente_nome[]" placeholder="Nome do Ingrediente (ex: Peito de Frango)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="ingrediente_qtd[]" placeholder="Qtd." step="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="ingrediente_unidade[]" placeholder="Unidade (g, ml, xícara)" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removerIngrediente(this)" disabled>X</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-ingrediente" class="btn btn-outline-success btn-sm mt-2">Adicionar Ingrediente</button>
            
            <hr class="my-4">

            <div class="mb-3">
                <label for="passoAPasso" class="form-label">Modo de Preparo</label>
                <textarea placeholder="Descreva o passo a passo da receita..." name="passoAPasso" id="passoAPasso" class="form-control" rows="5"></textarea>
            </div>
            <div class="mb-3">
                 <label for="observacoes" class="form-label">Observações Adicionais (Opcional)</label>
                <textarea placeholder="Dicas de armazenamento, substituições, etc." name="observacoes" id="observacoes" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Cadastrar Receita</button>
        </form>
        <a href="../views/perfil.php" class="d-block text-center mt-3">Voltar ao Perfil</a>
    </div>

<script>
    // Adiciona um novo campo de ingrediente ao clicar no botão
    document.getElementById('add-ingrediente').addEventListener('click', function() {
        const container = document.getElementById('ingredientes-container');
        const novaLinha = container.children[0].cloneNode(true); // Clona a primeira linha de ingrediente
        
        // Limpa os valores dos campos clonados
        novaLinha.querySelectorAll('input').forEach(input => input.value = '');
        // Habilita o botão de remover na nova linha
        novaLinha.querySelector('.btn-danger').disabled = false;
        
        container.appendChild(novaLinha);
    });

    // Remove a linha do ingrediente correspondente ao botão clicado
    function removerIngrediente(botao) {
        botao.closest('.ingrediente-row').remove();
    }
</script>

</body>
</html>