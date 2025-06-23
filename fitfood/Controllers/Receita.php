<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;
use \PDO;

class Receita {
    private $refeicoes;

    public function __construct() {
        $this->refeicoes = new Conexao('refeicoes');
    }

    public function showForm() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $tipos = new Conexao('tipos_refeicao');
        $tiposRefeicao = $tipos->select()->fetchAll(PDO::FETCH_OBJ);
        
        $data = [
            'titulo' => 'Nova Receita',
            'tipos_refeicao' => $tiposRefeicao
        ];
        
        view('receitas/form', $data);
    }

    public function save() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }

        $dados = [
            'nome' => $_POST['nome'],
            'tipo_refeicao_id' => $_POST['tipo_refeicao_id'],
            'nutricionista_criador_id' => $_SESSION['user_id']
        ];

        $this->refeicoes->insert($dados);
        redirectPage(base_url('nutricionista/dashboard'), ['texto' => 'Receita criada!', 'color' => 'success']);
    }
}