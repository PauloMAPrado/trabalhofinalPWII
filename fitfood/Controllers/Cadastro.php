<?php
namespace Controllers;

require_once("Config/Helpers.php");
use Controllers\Nutricionista;
use Controllers\Paciente;

class Cadastro {
    public function showForm() {
        return view('cadUser ');
    }

    public function save() {
        $userType = $_POST['userType'] ?? null;
        switch ($userType) {
            case 'nutricionista':
                $nutricionistaController = new Nutricionista();
                $nutricionistaController->save();
                break;
            case 'paciente':
                if (!isset($_SESSION['nutri_id'])) {
                    header("Location: " . base_url('login') . "?erro=autenticacao");
                    exit;
                }
                $pacienteController = new Paciente();
                $pacienteController->save();
                break;
            default:
                header("Location: " . base_url('cadastro') . "?erro=tipo_invalido");
                exit;
        }
    }
}
