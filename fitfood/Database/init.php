<?php
require_once(__DIR__ . '/Database.php');
use Models\Database;

try {
    // Conecta diretamente ao MySQL sem especificar banco
    $pdo = new PDO('mysql:host=mysql;port=3306;charset=utf8', 'aluno', '123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Lê e executa o SQL
    $sql = file_get_contents(__DIR__ . '/fitfood.sql');
    $pdo->exec($sql);
    
    echo "Banco criado com sucesso!";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>