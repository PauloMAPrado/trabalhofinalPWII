<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");

use Models\Database as Conexao;
use \PDO;

class User{

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
        
        $this->data['pagina'] = 'User';
        return view('user/index',$this->data);
    }
    
}
