<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Nutricionista{

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

    // Chama o formulário de cadastro
    function new(){
        $this->data['nutricionistas'] = (object) [
            'nutricionistas_nome' => '',
            'nutricionistas_crn' => '',
            'nutricionistas_telefone' => '',
            'nutricionistas_email' => '',
            'nutricionistas_endereco' => '',
            'nutricionistas_senha' => '',
            'nutricionistas_especialidade' => '',
        ];
        $this->data['pagina'] = 'Cadastrar nutricionistas';
        $this->data['method'] = 'save';
        return view('nutricionistas/form',$this->data);
    }


    

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'nutricionistas_nome'=> $requests['nutricionistas_nome'],
            'nutricionistas_crn' => $requests['nutricionistas_crn'],
            'nutricionistas_telefone' => $requests['nutricionistas_telefone'],
            'nutricionistas_email' => $requests['nutricionistas_email'],
            'nutricionistas_endereco' => $requests['nutricionistas_endereco'],
            'nutricionistas_senha' => md5($requests['nutricionistas_senha']),
            'nutricionistas_especialidade' => $requests['nutricionistas_especialidade'],
            'nutricionistas_nivel' => 1,
            ];

        if(($this->nutricionistas)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        nutricionistas::redirect(base_url('nutricionistas'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $this->data['nutricionistas'] = ($this->nutricionistas)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar nutricionistas';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('nutricionistas/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['nutricionistas'] = ($this->nutricionistas)->select($join=null,'nutricionistas_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar nutricionistas';
        $this->data['method'] = 'edit_save';

        return view('nutricionistas/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'nutricionistas_nome like "%'.$requests['pesquisar'].'%"'; 
            $this->data['nutricionistas'] = ($this->nutricionistas)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['nutricionistas']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar nutricionistas';
            return view('nutricionistas/index',$this->data);

        }else{
            nutricionistas::redirect(base_url('nutricionistas'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'nutricionistas_nome'=> $requests['nutricionistas_nome'],
                    'nutricionistas_crn' => $requests['nutricionistas_crn'],
                    'nutricionistas_telefone' => $requests['nutricionistas_telefone'],
                    'nutricionistas_email' => $requests['nutricionistas_email'],
                    'nutricionistas_endereco' => $requests['nutricionistas_endereco'],
                    'nutricionistas_senha' => md5($requests['nutricionistas_senha']),
                    'nutricionistas_especialidade' => $requests['nutricionistas_especialidade'],
                  
                ];

        if($this->nutricionistas->update('nutricionistas_id = '.$requests['nutricionistas_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        nutricionistas::redirect(base_url('nutricionistas'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->nutricionistas)->delete('nutricionistas_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        nutricionistas::redirect(base_url('nutricionistas'),$msg);

    }
    

    
}


