<?php
session_start();

require_once("Controllers/Nutricionista.php");
require_once("Controllers/Paciente.php");

use Controllers\Nutricionista;
use Controllers\Paciente;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userType = $_POST['userType'] ?? null;

    // Decide qual controller instanciar e qual método chamar
    switch ($userType) {
        case 'nutricionista':
            // Cria uma instância do controller de Nutricionista
            $nutricionistaController = new Nutricionista();
            // Chama o método save() para cadastrar o nutricionista
            $nutricionistaController->save();
            break;

        case 'paciente':
            if (!isset($_SESSION['nutri_id'])) {
                header("Location: login.php?erro=autenticacao");
                exit;
            }

            // Cria uma instância do controller de Paciente
            $pacienteController = new Paciente();
            // Chama o método save() para cadastrar o paciente
            $pacienteController->save();
            break;

        default:
            header("Location: pagina_de_cadastro.php?erro=tipo_invalido");
            exit;
    }
} else {
    header("Location: pagina_de_cadastro.php");
    exit;
}