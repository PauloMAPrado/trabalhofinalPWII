<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;
use \PDO;

class PacienteReceita {
    
    public function atribuir($pacienteId) {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $refeicoes = new Conexao('refeicoes');
        $receitas = $refeicoes->select('nutricionista_criador_id = ?', [$_SESSION['user_id']])->fetchAll(PDO::FETCH_OBJ);
        
        $pacientes = new Conexao('pacientes');
        $paciente = $pacientes->select('id = ? AND nutricionista_id = ?', [$pacienteId, $_SESSION['user_id']])->fetch(PDO::FETCH_OBJ);
        
        $data = [
            'titulo' => 'Atribuir Receitas',
            'paciente' => $paciente,
            'receitas' => $receitas
        ];
        
        view('pacientes/receitas', $data);
    }
    
    public function salvar() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        // Verifica se paciente existe e pertence ao nutricionista
        $pacientes = new Conexao('pacientes');
        $paciente = $pacientes->select('id = ? AND nutricionista_id = ?', [$_POST['paciente_id'], $_SESSION['user_id']])->fetch(PDO::FETCH_OBJ);
        
        if (!$paciente) {
            redirectPage(base_url('pacientes'), ['texto' => 'Paciente não encontrado!', 'color' => 'danger']);
        }
        
        if (empty($_POST['receitas'])) {
            redirectPage(base_url('pacientes'), ['texto' => 'Selecione pelo menos uma receita!', 'color' => 'danger']);
        }
        
        $pacienteReceitas = new Conexao('paciente_receitas');
        
        foreach ($_POST['receitas'] as $receitaId) {
            $dados = [
                'paciente_id' => $_POST['paciente_id'],
                'refeicao_id' => $receitaId,
                'observacoes' => $_POST['observacoes'] ?? null
            ];
            
            $pacienteReceitas->insert($dados);
        }
        
        redirectPage(base_url('pacientes'), ['texto' => 'Receitas atribuídas!', 'color' => 'success']);
    }
}