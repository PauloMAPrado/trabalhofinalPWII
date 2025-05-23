<?php

if(!isset($_SESSION['usuario_logado'])){
    if((!isset($_SESSION['usuario_logado']->usuarios_nivel == 2))){

?>

<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class Usuarios{

    private $usuarios;
    private $data;

    function __construct(){
        $this->usuarios = new Conexao('usuarios');
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
        $this->data['usuarios'] = (object) [
            'usuarios_id' => '',
            'usuarios_nome' => '',
            'usuarios_sobrenome' => '',
            'usuarios_cpf' => '',
            'usuarios_email' => '',
            'usuarios_senha' => '',
            'usuarios_fone' => '',
        ];
        $this->data['pagina'] = 'Cadastrar usuarios';
        $this->data['method'] = 'save';
        return view('usuarios/form',$this->data);
    }

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'usuarios_nome'=> $requests['usuarios_nome'],
            'usuarios_sobrenome' => $requests['usuarios_sobrenome'],
            'usuarios_cpf' => $requests['usuarios_cpf'],
            'usuarios_email' => $requests['usuarios_email'],
            'usuarios_senha' => md5($requests['usuarios_senha']),
            'usuarios_fone' => $requests['usuarios_fone'],
            'usuarios_nivel' => 1,
            ];

        if(($this->usuarios)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        Usuarios::redirect(base_url('usuarios'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $this->data['usuarios'] = ($this->usuarios)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar usuarios';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('usuarios/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['usuarios'] = ($this->usuarios)->select($join=null,'usuarios_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar usuarios';
        $this->data['method'] = 'edit_save';

        return view('usuarios/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'usuarios_nome like "%'.$requests['pesquisar'].'%"'; 
            $this->data['usuarios'] = ($this->usuarios)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['usuarios']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar usuarios';
            return view('usuarios/index',$this->data);

        }else{
            Usuarios::redirect(base_url('usuarios'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'usuarios_nome'=> $requests['usuarios_nome'],
                    'usuarios_sobrenome' => $requests['usuarios_sobrenome'],
                    'usuarios_cpf' => $requests['usuarios_cpf'],
                    'usuarios_email' => $requests['usuarios_email'],
                    'usuarios_fone' => $requests['usuarios_fone'],
                ];

        if($this->usuarios->update('usuarios_id = '.$requests['usuarios_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        Usuarios::redirect(base_url('usuarios'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->usuarios)->delete('usuarios_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        Usuarios::redirect(base_url('usuarios'),$msg);

    }
    

    
}


// $dados = new Usuarios();
// print_r($dados->index());
?>

<?php

    }else{
        $msg = "Você não tem permissão para acessar esta página.";
        redirectPage(base_url('login'), $msg);
        exit;
    }

}else{
    redirectPage(base_url('login'), $msg);
    exit;
}

?>