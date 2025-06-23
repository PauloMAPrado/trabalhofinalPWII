<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;
use \PDO;

class Paciente {
    private $pacientes;

    function __construct(){
        $this->pacientes = new Conexao('pacientes');
    }

    function index(){
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $pacientes = $this->pacientes->select('nutricionista_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);
        
        $data = [
            'titulo' => 'Meus Pacientes',
            'pacientes' => $pacientes
        ];
        
        return view('pacientes/index', $data);
    }

    function showForm(){
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $data = ['titulo' => 'Novo Paciente'];
        return view('pacientes/form', $data);
    }

    function save(){
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

        $this->pacientes->insert($dados);
        redirectPage(base_url('pacientes'), ['texto' => 'Paciente cadastrado!', 'color' => 'success']);
    }

    function edit($id){
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $paciente = $this->pacientes->select('id = ? AND nutricionista_id = ?', [$id, $_SESSION['user_id']])->fetch(PDO::FETCH_OBJ);
        
        if (!$paciente) {
            redirectPage(base_url('pacientes'), ['texto' => 'Paciente não encontrado!', 'color' => 'danger']);
        }
        
        $data = [
            'titulo' => 'Editar Paciente',
            'paciente' => $paciente
        ];
        
        return view('pacientes/form', $data);
    }

    function update(){
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $dados = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'data_nascimento' => $_POST['data_nascimento'] ?? null
        ];
        
        if (!empty($_POST['senha'])) {
            $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        }

        $this->pacientes->update('id = ? AND nutricionista_id = ?', [$_POST['id'], $_SESSION['user_id']], $dados);
        redirectPage(base_url('pacientes'), ['texto' => 'Paciente atualizado!', 'color' => 'success']);
    }

    function delete(){
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $this->pacientes->delete('id = ? AND nutricionista_id = ?', [$_POST['id'], $_SESSION['user_id']]);
        redirectPage(base_url('pacientes'), ['texto' => 'Paciente excluído!', 'color' => 'success']);
    }
}