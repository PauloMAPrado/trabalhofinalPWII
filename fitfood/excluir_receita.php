<?php
session_start();
require_once 'Database/Database.php';
use Models\Database;

if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] !== 'nutricionista') {
    header('Location: login_simples.php');
    exit;
}

if ($_POST && isset($_POST['id'])) {
    $receitaId = $_POST['id'];
    
    // Verificar se a receita pertence ao nutricionista
    $refeicoes = new Database('refeicoes');
    $receita = $refeicoes->select('id = ? AND nutricionista_criador_id = ?', [$receitaId, $_SESSION['user_id']])->fetch(PDO::FETCH_OBJ);
    
    if ($receita) {
        // Excluir receita (os alimentos serão excluídos automaticamente por CASCADE)
        $refeicoes->delete('id = ?', [$receitaId]);
        header('Location: receitas.php?msg=Receita excluída com sucesso!');
    } else {
        header('Location: receitas.php?msg=Receita não encontrada!');
    }
} else {
    header('Location: receitas.php');
}
exit;
?>