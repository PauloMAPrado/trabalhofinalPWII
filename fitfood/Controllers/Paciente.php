<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Paciente {

    private $pacientes;
    private $data;

    function __construct(){
        // Altera o nome da tabela para 'pacientes'
        $this->pacientes = new Conexao('pacientes');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    // Chama o formulário de cadastro de um novo paciente
    function new(){
        $this->data['pacientes'] = (object) [
            'pacientes_nome' => '',
            'pacientes_data_nascimento' => '',
            'pacientes_altura' => '',
            'pacientes_peso' => '',
            'pacientes_email' => '',
            'pacientes_senha' => '',
            'chave_acesso' => '', // Campo gerado automaticamente
        ];
        $this->data['pagina'] = 'Cadastrar Paciente';
        $this->data['method'] = 'save';
        return view('pacientes/form', $this->data);
    }

    // C - Função Cadastrar (Salvar)
    function save(){
        $requests = $_REQUEST;

        $parte_nome = strtoupper(substr($requests['pacientes_nome'], 0, 3));
        $parte_data = date('d', strtotime($requests['pacientes_data_nascimento']));
        $chave_acesso = $parte_nome . $parte_data;

        $values = [
    
            'nutricionista_id' => $_SESSION['nutri_id'], 
            'pacientes_nome' => $requests['pacientes_nome'],
            'pacientes_data_nascimento' => $requests['pacientes_data_nascimento'],
            'pacientes_altura' => $requests['pacientes_altura'],
            'pacientes_peso' => $requests['pacientes_peso'],
            'pacientes_email' => $requests['pacientes_email'],
            'pacientes_senha' => password_hash($requests['pacientes_senha'], PASSWORD_DEFAULT), 
            'chave_acesso' => $chave_acesso,
        ];

        if (($this->pacientes)->insert($values)) {
            $msg = ['texto' => 'Paciente Cadastrado com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao cadastrar paciente!', 'color' => 'danger'];
        }
        // Redireciona para a lista de pacientes
        self::redirect(base_url('pacientes'), $msg);
    }

    // R - Função Listar todos os pacientes
    function index(){
        // Idealmente, você deve listar apenas os pacientes do nutricionista logado
        $nutricionista_id = $_SESSION['nutri_id'];
        $where = 'nutricionista_id = ' . $nutricionista_id;

        $this->data['pacientes'] = ($this->pacientes)->select($join = null, $where, $order = null, $limit = null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar Pacientes';
        if (isset($_SESSION['msg'])) {
            unset($_SESSION['msg']);
        }
        return view('pacientes/index', $this->data);
    }

    // R - Função para chamar o formulário de edição
    function edit($id){
        $this->data['pacientes'] = ($this->pacientes)->select($join = null, 'pacientes_id = ' . $id)->fetchObject();
        $this->data['pagina'] = 'Alterar Paciente';
        $this->data['method'] = 'edit_save';

        return view('pacientes/form', $this->data);
    }

    // R - Função Pesquisar por um paciente
    function search(){
        $requests = $_REQUEST;
        if (isset($requests['pesquisar'])) {
            $nutricionista_id = $_SESSION['nutri_id']; // Garante que a busca seja só nos seus pacientes
            $where = 'nutricionista_id = ' . $nutricionista_id . ' AND pacientes_nome LIKE "%' . $requests['pesquisar'] . '%"';
            
            $this->data['pacientes'] = ($this->pacientes)->select(null, $where, null, null)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                'texto' => "Total de registros encontrados: " . count($this->data['pacientes']),
                'color' => "success"
            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar Pacientes';
            return view('pacientes/index', $this->data);
        } else {
            self::redirect(base_url('pacientes'));
        }
    }

    // U - Função Alterar (Salvar Edição)
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
            'pacientes_nome' => $requests['pacientes_nome'],
            'pacientes_data_nascimento' => $requests['pacientes_data_nascimento'],
            'pacientes_altura' => $requests['pacientes_altura'],
            'pacientes_peso' => $requests['pacientes_peso'],
            'pacientes_email' => $requests['pacientes_email'],
        ];

        // Opcional: Altera a senha apenas se uma nova for digitada
        if (!empty($requests['pacientes_senha'])) {
            $values['pacientes_senha'] = password_hash($requests['pacientes_senha'], PASSWORD_DEFAULT);
        }

        if ($this->pacientes->update('pacientes_id = ' . $requests['pacientes_id'], $values)) {
            $msg = ['texto' => 'Paciente Alterado com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao alterar paciente!', 'color' => 'danger'];
        }
        self::redirect(base_url('pacientes'), $msg);
    }

    // D - Função Deletar
    function delete($id){
        if (($this->pacientes)->delete('pacientes_id = ' . $id)) {
            $msg = ['texto' => 'Paciente Excluído com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao excluir paciente!', 'color' => 'danger'];
        }
        self::redirect(base_url('pacientes'), $msg);
    }
}