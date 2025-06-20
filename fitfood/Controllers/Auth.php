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
        $this->usuarios = new Conexao('usuarios');
    }

    protected function redirect($path, $message = null) {
        if ($message) {
            $_SESSION['msg'] = $message;
        }
        header("Location: {$path}");
        exit;
    }

    function index() {
        $this->data['pagina'] = 'Login';
        return view('login/index', $this->data);
    }

    function auth() {
        $requests = $_REQUEST;
        $login = $requests['login'];
        $senha = md5($requests['senha']);
        $where = "usuarios_cpf = '{$login}' OR usuarios_email = '{$login}' AND usuarios_senha = '{$senha}'";
        $usuario = $this->usuarios->select(null, $where)->fetchObject();

        if ($usuario) {
            if ($usuario->usuarios_nivel == 2) {
                $_SESSION['usuario_logado'] = $usuario;
                $msg = ['texto' => 'Login realizado com sucesso!', 'color' => 'success'];
                $this->redirect(base_url('admin'), $msg);
            } else if ($usuario->usuarios_nivel == 1) {
                $_SESSION['usuario_logado'] = $usuario;
                $msg = ['texto' => 'Login realizado com sucesso!', 'color' => 'success'];
                $this->redirect(base_url('user'), $msg);
            } else {
                $msg = ['texto' => 'Acesso não autorizado!', 'color' => 'danger'];
                $this->redirect(base_url('login/index'), $msg);
            }
        } else {
            $msg = ['texto' => 'Usuário ou senha inválido!', 'color' => 'danger'];
            $this->redirect(base_url('login'), $msg);
        }
    }

    function logout() {
        unset($_SESSION['usuario_logado']);
        session_destroy();
        $msg = ['texto' => 'Sessão encerrada com sucesso!', 'color' => 'success'];
        $this->redirect(base_url('home'), $msg);
    }
}
