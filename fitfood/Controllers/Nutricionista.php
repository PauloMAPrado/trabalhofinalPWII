<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Nutricionista {

    private $nutricionistas;
    private $data;

    function __construct(){
        $this->nutricionistas = new Conexao('nutricionistas');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    function new(){
        $this->data['nutricionista'] = (object) [
            'nutricionistas_nome' => '',
            'nutricionistas_crn' => '',
            'nutricionistas_telefone' => '',
            'nutricionistas_email' => '',
            'nutricionistas_endereco' => '',
            'nutricionistas_senha' => '',
            'nutricionistas_especialidade' => '',
        ];
        $this->data['pagina'] = 'Cadastrar Nutricionista';
        $this->data['method'] = 'save';
        return view('nutricionistas/form', $this->data);
    }

    // C - Função Cadastrar (Salvar)
    function save(){
        $requests = $_POST; 

        $values = [
            'nutricionistas_nome'=> $requests['nutricionistas_nome'],
            'nutricionistas_crn' => $requests['nutricionistas_crn'],
            'nutricionistas_telefone' => $requests['nutricionistas_telefone'],
            'nutricionistas_email' => $requests['nutricionistas_email'],
            'nutricionistas_endereco' => $requests['nutricionistas_endereco'],
            'nutricionistas_senha' => password_hash($requests['nutricionistas_senha'], PASSWORD_DEFAULT),
            'nutricionistas_especialidade' => $requests['nutricionistas_especialidade'],
            'nutricionistas_nivel' => 1, // Exemplo de nível de acesso
        ];

        if (($this->nutricionistas)->insert($values)) {
            $msg = ['texto' => 'Nutricionista Cadastrado com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao cadastrar nutricionista!', 'color' => 'danger'];
        }
        self::redirect(base_url('nutricionistas'), $msg);
    }

    // R - Função Listar todos os nutricionistas
    function index(){
        $this->data['nutricionistas'] = ($this->nutricionistas)->select(null, null, null, null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar Nutricionistas';
        if (isset($_SESSION['msg'])) {
            unset($_SESSION['msg']);
        }
        return view('nutricionistas/index', $this->data);
    }

    // R - Função para chamar o formulário de edição
    function edit($id){
        $this->data['nutricionista'] = ($this->nutricionistas)->select(null, 'nutricionistas_id = ' . $id)->fetchObject();
        $this->data['pagina'] = 'Alterar Nutricionista';
        $this->data['method'] = 'edit_save';

        return view('nutricionistas/form', $this->data);
    }

    // R - Função Pesquisar por um nutricionista
    function search(){
        $requests = $_POST;
        if (isset($requests['pesquisar'])) {
            $where = 'nutricionistas_nome LIKE "%' . $requests['pesquisar'] . '%"'; 
            
            $this->data['nutricionistas'] = ($this->nutricionistas)->select(null, $where, null, null)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                'texto' => "Total de registros encontrados: " . count($this->data['nutricionistas']),
                'color' => "success"
            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar Nutricionistas';
            return view('nutricionistas/index', $this->data);
        } else {
            self::redirect(base_url('nutricionistas'));
        }
    }

    // U - Função Alterar (Salvar Edição)
    function edit_save(){
        $requests = $_POST;
        $values = [
            'nutricionistas_nome' => $requests['nutricionistas_nome'],
            'nutricionistas_crn' => $requests['nutricionistas_crn'],
            'nutricionistas_telefone' => $requests['nutricionistas_telefone'],
            'nutricionistas_email' => $requests['nutricionistas_email'],
            'nutricionistas_endereco' => $requests['nutricionistas_endereco'],
            'nutricionistas_especialidade' => $requests['nutricionistas_especialidade'],
        ];

        if (!empty($requests['nutricionistas_senha'])) {
            $values['nutricionistas_senha'] = password_hash($requests['nutricionistas_senha'], PASSWORD_DEFAULT);
        }

        if ($this->nutricionistas->update('nutricionistas_id = ' . $requests['nutricionistas_id'], $values)) {
            $msg = ['texto' => 'Nutricionista Alterado com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao alterar nutricionista!', 'color' => 'danger'];
        }
        self::redirect(base_url('nutricionistas'), $msg);
    }

    // D - Função Deletar
    function delete($id){
        if (($this->nutricionistas)->delete('nutricionistas_id = ' . $id)) {
            $msg = ['texto' => 'Nutricionista Excluído com Sucesso!', 'color' => 'success'];
        } else {
            $msg = ['texto' => 'Erro ao excluir nutricionista!', 'color' => 'danger'];
        }
        self::redirect(base_url('nutricionistas'), $msg);
    }
}