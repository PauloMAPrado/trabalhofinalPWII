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

class Categorias{

    private $categorias;
    private $data;

    
    function __construct(){
        $this->categorias = new Conexao('categorias');
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
        $this->data['categorias'] = (object) [
            'categorias_id' => '',
            'categorias_nome' => '',
        ];
        $this->data['pagina'] = 'Cadastrar categorias';
        $this->data['method'] = 'save';
        return view('categorias/form',$this->data);
    }

    // C - Função Cadastrar
    function save(){
        $requests = $_REQUEST;

        $values = [
            'categorias_nome'=> $requests['categorias_nome']

            ];

        if(($this->categorias)->insert($values)){
            $msg = ['texto'=>'Cadastrado com Sucesso!','color'=>'success'];
        }else{
            $msg= ['texto'=>'Não foi cadastrado!','color'=>'danger'];
        }
        Categorias::redirect(base_url('categorias'),$msg);

    }


    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        
        $this->data['categorias'] = ($this->categorias)->select($join=null, $where=null,$order=null,$limit=null)->fetchAll(PDO::FETCH_CLASS);
        $this->data['pagina'] = 'Listar categorias';
        if(isset($_SESSION['msg'])){
            unset($_SESSION['msg']);
        }
        return view('categorias/index',$this->data);
    }

    //R - Função editar  - Lista um registro da tabela filtrado por id
    function edit($id){
        $this->data['categorias'] = ($this->categorias)->select($join=null,'categorias_id = '.$id)->fetchObject();
        $this->data['pagina'] = 'Alterar categorias';
        $this->data['method'] = 'edit_save';

        return view('categorias/form',$this->data);
    }

    //R - Função Pesquisar por um valor
    function search(){
        $requests = $_REQUEST;
        if(isset($requests['pesquisar'])){
            $join = null;
            $where = null;
            $order = null;
            $limit = null;
            $where = 'categorias_nome like "%'.$requests['pesquisar'].'%"'; 
            $this->data['categorias'] = ($this->categorias)->select($join,$where,$order,$limit)->fetchAll(PDO::FETCH_CLASS);
            $msg = [
                            'texto'=>"Total de registros: ".count($this->data['categorias']),
                            'color'=>"success"
                            ];
            $_SESSION['msg'] = $msg;
            $this->data['pagina'] = 'Pesquisar categorias';
            return view('categorias/index',$this->data);

        }else{
            Categorias::redirect(base_url('categorias'),$msg);
        }
        

    }

    //U - Função Alterar
    function edit_save(){
        $requests = $_REQUEST;
        $values = [
                    'categorias_nome' => $requests['categorias_nome']
                ];

        if($this->categorias->update('categorias_id = '.$requests['categorias_id'],$values)){
            $msg = ['texto'=>'Alterado com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi alterado!','color'=>'danger'];
        }
        Categorias::redirect(base_url('categorias'),$msg);

    }

    //D - Função Deletar
    function delete($id){

        if(($this->categorias)->delete('categorias_id = '.$id)){
            $msg = ['texto'=>'Exluido com Sucesso!','color'=>'success'];
        }else{
            $msg = ['texto'=>'Não foi Excluido!','color'=>'danger'];
        }
        Categorias::redirect(base_url('categorias'),$msg);

    }
    

    
}


// $dados = new Categorias();
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