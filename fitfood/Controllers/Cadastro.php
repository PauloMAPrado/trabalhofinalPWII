<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;

class Cadastro {
    public function showForm() {
        return view('cadUser');
    }

    public function save() {
        $userType = $_POST['userType'] ?? null;
        
        if ($userType === 'nutricionista') {
            $this->saveNutricionista();
        } elseif ($userType === 'paciente') {
            $this->savePaciente();
        } else {
            redirectPage(base_url('cadastro'), ['texto' => 'Tipo inválido!', 'color' => 'danger']);
        }
    }
    
    private function saveNutricionista() {
        $dados = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            'crn' => $_POST['crn'] ?? null,
            'telefone' => $_POST['telefone'] ?? null
        ];
        
        $nutricionistas = new Conexao('nutricionistas');
        $nutricionistas->insert($dados);
        
        redirectPage(base_url('login'), ['texto' => 'Cadastro realizado!', 'color' => 'success']);
    }
    
    private function savePaciente() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $dados = [
            'nutricionista_id' => $_SESSION['user_id'],
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            'data_nascimento' => $_POST['data_nascimento'] ?? null
        ];
        
        $pacientes = new Conexao('pacientes');
        $pacientes->insert($dados);
        
        redirectPage(base_url('pacientes'), ['texto' => 'Paciente cadastrado!', 'color' => 'success']);
    }
}
