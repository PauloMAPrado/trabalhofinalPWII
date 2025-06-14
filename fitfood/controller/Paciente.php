<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Pacientes{

    private $pacientes;
    private $data;

    function __construct(){
        $this->pacientes = new Conexao('pacientes');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    // Chama o formulário de cadastro
    function new(){
        $this->data['pacientes'] = (object) [
            'pacientes_id' => '',
            'pacientes_nome' => '',
            'pacientes_dt_nasc' => '',
            'pacientes_altura' => '',
            'pacientes_peso' => '',
            'usaruios_imc' => '',
            'pacientes_email' => '',
            'pacientes_senha' => '',
        ];
        $this->data['pagina'] = 'Cadastrar pacientes';
        $this->data['method'] = 'save';
        return view('pacientes/form',$this->data);
    }


    // Método para gerar a chave de acesso
    private function gerarChaveAcesso($nome, $dataNascimento) {
    // Pega as 3 primeiras letras do nome
        $letrasNome = substr($nome, 0, 3);

    // Extrai o primeiro dia da data de nascimento
        $diaNascimento = substr($dataNascimento, 8, 2);

    // Retorna a chave de acesso
        return strtoupper($letrasNome) . $diaNascimento;
    }

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'pacientes_nome'=> $requests['pacientes_nome'],
            'pacientes_dt_nasc' => $requests['pacientes_dt_nasc'],
            'pacientes_altura' => $requests['pacientes_altura'],
            'pacientes_peso' => $requests['pacientes_peso'],
            'pacientes_imc' => $requests['pacientes_imc'],
            'pacientes_email' => $requests['pacientes_email'],
            'pacientes_senha' => md5($requests['pacientes_senha']),
            'pacientes_nivel' => 1,
            ];

        if(($this->pacientes)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        pacientes::redirect(base_url('pacientes'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $this->data['pacientes'] = ($this->pacientes)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar pacientes';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('pacientes/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['pacientes'] = ($this->pacientes)->select($join=null,'pacientes_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar pacientes';
        $this->data['method'] = 'edit_save';

        return view('pacientes/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'pacientes_nome like "%'.$requests['pesquisar'].'%"'; 
            $this->data['pacientes'] = ($this->pacientes)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['pacientes']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar pacientes';
            return view('pacientes/index',$this->data);

        }else{
            pacientes::redirect(base_url('pacientes'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'pacientes_nome'=> $requests['pacientes_nome'],
                    'pacientes_dt_nasc' => $requests['pacientes_dt_nasc'],
                    'pacientes_altura' => $requests['pacientes_altura'],
                    'pacientes_peso' => $requests['pacientes_peso'],
                    'pacientes_imc' => $requests['pacientes_imc'],
                    'pacientes_email' => $requests['pacientes_email'],
                  
                ];

        if($this->pacientes->update('pacientes_id = '.$requests['pacientes_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        pacientes::redirect(base_url('pacientes'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->pacientes)->delete('pacientes_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        pacientes::redirect(base_url('pacientes'),$msg);

    }
    

    
}


