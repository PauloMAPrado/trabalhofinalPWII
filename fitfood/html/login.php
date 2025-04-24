<?php
require_once '../config/database.php';
require_once '../controllers/AuthController.php';

// Inicia a sessão
session_start();

// Se já estiver logado, redireciona
if(isset($_SESSION['usuario'])) {
    header("Location: /dashboard.php");
    exit();
}

// Conexão com o banco
$database = new Database();
$db = $database->getConnection();

// Processa o login
$authController = new AuthController($db);
$erro = null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';
    
    $usuario = $authController->login($email, $senha);
    
    if($usuario) {
        $_SESSION['usuario'] = $usuario;
        
        // Redireciona conforme o tipo de usuário
        $pagina = ($usuario['tipo'] === 'nutricionista') ? 'nutricionista/dashboard.php' : 'paciente/dashboard.php';
        header("Location: /$pagina");
        exit();
    } else {
        $erro = "Email ou senha incorretos!";
    }
}
?>