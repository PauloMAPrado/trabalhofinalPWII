<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="shortcut icon" href="../public/img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <title>FitFood | Cadastro</title>
</head>
<body>
    <div class="loginBox">
        <h1 class="loginTitle">FitFood | Cadastro</h1>
        
        <form action="Cadastro.php" method="POST">
            
            <div class="textbox">
                <label for="userType">Tipo de Usuário:</label>
                <select name="userType" id="userType" required>
                    <option value="nutricionista" selected>Nutricionista</option>
                    <option value="paciente">Paciente</option>
                </select>
            </div>
            
            <hr>

            <div class="textbox">
                <input type="text" placeholder="Nome Completo" name="nome" id="nome" required>
            </div>

            <div id="nutriFields">
                <div class="textbox">
                    <input type="text" placeholder="CRN (Conselho Regional de Nutricionistas)" name="crn">
                </div>
                <div class="textbox">
                    <input type="tel" placeholder="Telefone" name="telefone" id="telefone">
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Endereço" name="endereco">
                </div>
            </div>

            <div id="pacienteFields">
                 <div class="textbox">
                    <label for="dataNascimento">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="dataNascimento">
                </div>
                 <div class="textbox">
                    <input type="number" placeholder="Altura (ex: 1.75)" step="0.01" name="altura">
                </div>
                <div class="textbox">
                    <input type="number" placeholder="Peso (ex: 70.5)" step="0.1" name="peso">
                </div>
                <div class="textbox">
                    <label for="chaveAcesso">Chave de Acesso (Gerada Automaticamente)</label>
                    <input type="text" name="chave_acesso" id="chaveAcesso" readonly>
                </div>
            </div>
            
            <hr>

            <div class="textbox">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="textbox">
                <input type="password" placeholder="Senha" name="senha" required>
            </div>

            <button type="submit" class="btn">Cadastrar</button>
        </form>
        <br>
        <a href="../index.php">Já tenho uma conta</a>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // SELEÇÃO DOS ELEMENTOS DO HTML
    const userTypeSelect = document.getElementById('userType');
    const nutriFields = document.getElementById('nutriFields');
    const pacienteFields = document.getElementById('pacienteFields');
    const nomeInput = document.getElementById('nome');
    const dataNascimentoInput = document.getElementById('dataNascimento');
    const chaveAcessoInput = document.getElementById('chaveAcesso');
    // NOVO: Seleciona o campo de telefone
    const telefoneInput = document.getElementById('telefone');

    // FUNÇÃO PARA ALTERNAR A VISIBILIDADE DOS CAMPOS
    function toggleFields() {
        if (userTypeSelect.value === 'nutricionista') {
            nutriFields.style.display = 'block';
            pacienteFields.style.display = 'none';
        } else {
            nutriFields.style.display = 'none';
            pacienteFields.style.display = 'block';
        }
    }
    
    // FUNÇÃO PARA GERAR A CHAVE DE ACESSO
    function generateAccessKey() {
        const nome = nomeInput.value.trim();
        const dataNasc = dataNascimentoInput.value;

        if (nome.length >= 3 && dataNasc) {
            const parteNome = nome.substring(0, 3).toUpperCase();
            const parteData = dataNasc.substring(8, 10);
            chaveAcessoInput.value = parteNome + parteData;
        } else {
            chaveAcessoInput.value = '';
        }
    }

    // --- NOVA LÓGICA PARA MÁSCARA DE TELEFONE ---
    const handlePhone = (event) => {
        let input = event.target;
        input.value = phoneMask(input.value);
    }

    const phoneMask = (value) => {
        if (!value) return "";
        value = value.replace(/\D/g,''); // 1. Remove tudo que não é dígito
        value = value.replace(/(\d{2})(\d)/,"($1) $2"); // 2. Coloca parênteses em volta dos dois primeiros dígitos
        value = value.replace(/(\d)(\d{4})$/,"$1-$2"); // 3. Coloca um hífen antes dos últimos 4 dígitos
        return value;
    }
    // --- FIM DA NOVA LÓGICA ---

    // ADICIONA OS "OUVINTES" DE EVENTOS
    userTypeSelect.addEventListener('change', toggleFields);
    nomeInput.addEventListener('input', generateAccessKey);
    dataNascimentoInput.addEventListener('input', generateAccessKey);
    // NOVO: Adiciona o ouvinte para o campo de telefone
    telefoneInput.addEventListener('input', handlePhone);

    // CHAMA A FUNÇÃO INICIALMENTE para configurar o formulário
    toggleFields();
});
</script>

</body>
</html>