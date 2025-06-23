<?php
namespace Controllers;

require_once(__DIR__ . '/../Database/Database.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Models\Database as Conexao;
use \PDO;

class Auth {
    private $usuarios;
    private $data;

    function __construct() {
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    function showLogin() {
        $this->data['pagina'] = 'Login';
        return view('login', $this->data);
    }

    function authenticate() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($email) || empty($senha)) {
            $_SESSION['msg'] = ['texto' => 'Preencha todos os campos!', 'color' => 'danger'];
            header('Location: ' . base_url('login'));
            exit;
        }

        // Tenta login como nutricionista
        $nutricionistas = new Conexao('nutricionistas');
        $nutri = $nutricionistas->select('email = ?', [$email])->fetch(\PDO::FETCH_OBJ);
        
        if ($nutri && password_verify($senha, $nutri->senha)) {
            $_SESSION['user_id'] = $nutri->id;
            $_SESSION['user_nome'] = $nutri->nome;
            $_SESSION['user_tipo'] = 'nutricionista';
            header('Location: ' . base_url('nutricionista/dashboard'));
            exit;
            
        }

        // Tenta login como paciente (email + chave de acesso)
        $pacientes = new Conexao('pacientes');
        $paciente = $pacientes->select('email = ? AND chave_acesso = ?', [$email, $senha])->fetch(\PDO::FETCH_OBJ);
        
        if ($paciente) {
            $_SESSION['user_id'] = $paciente->id;
            $_SESSION['user_nome'] = $paciente->nome;
            $_SESSION['user_tipo'] = 'paciente';
            header('Location: ' . base_url('/'));
            exit;
        }

        $_SESSION['msg'] = ['texto' => 'Email ou chave incorretos!', 'color' => 'danger'];
        header('Location: ' . base_url('login'));
        exit;
    }

    function logout() {
        session_destroy();
        header('Location: ' . base_url('/'));
        exit;
    }
}
