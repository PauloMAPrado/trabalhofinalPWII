<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;

class Nutricionista {
    
    public function dashboard() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $data = [
            'titulo' => 'Dashboard Nutricionista',
            'usuario' => $_SESSION['user_nome']
        ];
        
        view('nutricionista/dashboard', $data);
    }
    
    public function showPerfil() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $nutricionistas = new Conexao('nutricionistas');
        $nutri = $nutricionistas->select('id = ?', [$_SESSION['user_id']])->fetch(\PDO::FETCH_OBJ);
        
        $data = [
            'titulo' => 'Meu Perfil',
            'nutricionista' => $nutri
        ];
        
        view('nutricionista/perfil', $data);
    }
    
    public function savePerfil() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['texto' => 'Acesso negado!', 'color' => 'danger']);
        }
        
        $dados = [
            'nome' => $_POST['nome'] ?? '',
            'crn' => $_POST['crn'] ?? '',
            'telefone' => $_POST['telefone'] ?? ''
        ];
        
        $nutricionistas = new Conexao('nutricionistas');
        $nutricionistas->update('id = ?', [$_SESSION['user_id']], $dados);
        
        redirectPage(base_url('nutricionista/perfil'), ['texto' => 'Perfil atualizado!', 'color' => 'success']);
    }
}