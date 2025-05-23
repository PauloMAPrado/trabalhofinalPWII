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

class Admin{

    private $data;

    
    function __construct(){
        #$this->categorias = new Conexao('categorias');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    //R - Função Listar todas os registros de uma tabela do BD
    function index(){
        
        $this->data['pagina'] = 'Admin';
        return view('admin/index',$this->data);
    }
    
}
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
