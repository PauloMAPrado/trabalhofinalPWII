<?php

namespace Controllers;

require_once("Models/Database.php");
require_once("Config/Helpers.php");
use Models\Database as Conexao;
use \PDO;

class Home{

    private $home;
    private $data;

    
    public function __construct(){
        // $this->cidades = new Conexao('cidades');
        $this->data['home'] = [];
    }

  

    public function index(){
        $this->data['home'] = "Home";
        $this->data['pagina'] = 'Home/index';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/index',$this->data);
    }


    public function precos(){
        $this->data['home'] = "Preços";
        $this->data['pagina'] = 'Home/precos';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/precos',$this->data);
    }

    public function anuncios(){
        $this->data['home'] = "Anuncios";
        $this->data['pagina'] = 'Home/anuncios';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/anuncios',$this->data);
    }

    public function contato(){
        $this->data['home'] = "Anuncios";
        $this->data['pagina'] = 'Home/anuncios';
        $this->data['msg'] = ''; 
        $this->data['op'] = 'listar';
        return view('home/contato',$this->data);
    }
    
}


// $dados = new Home();
// print_r($dados->index());


