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

class Cidades{

    private $cidades;
    private $data;

    
    function __construct(){
        $this->cidades = new Conexao('cidades');
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
        $this->data['cidades'] = (object) [
            'cidades_id' => '',
            'cidades_nome' => '',
            'cidades_uf' => '',
        ];
        $this->data['pagina'] = 'Cadastrar cidades';
        $this->data['method'] = 'save';
        return view('cidades/form',$this->data);
    }

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'cidades_nome'=> $requests['cidades_nome'],
            'cidades_uf'  => $requests['cidades_uf']
            ];

        if(($this->cidades)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        Cidades::redirect(base_url('cidades'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        $this->data['cidades'] = ($this->cidades)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar cidades';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('cidades/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['cidades'] = ($this->cidades)->select($join=null,'cidades_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar cidades';
        $this->data['method'] = 'edit_save';

        return view('cidades/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'cidades_nome like "%'.$requests['pesquisar'].'%"'; 
            $this->data['cidades'] = ($this->cidades)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['cidades']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar cidades';
            return view('cidades/index',$this->data);

        }else{
            Cidades::redirect(base_url('cidades'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'cidades_nome' => $requests['cidades_nome'],
                    'cidades_uf'   => $requests['cidades_uf']
                ];

        if($this->cidades->update('cidades_id = '.$requests['cidades_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        Cidades::redirect(base_url('cidades'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->cidades)->delete('cidades_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        Cidades::redirect(base_url('cidades'),$msg);

    }
    

    
}


// $dados = new Cidades();
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