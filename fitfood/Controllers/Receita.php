<?php
namespace Controllers;

// Inclui a classe mãe Crud e os helpers
require_once(__DIR__ . '/../Config/Crud.php');
require_once(__DIR__ . '/../Config/Helpers.php');

use Config\Crud;
use \PDO;

class ReceitaController extends Crud
{
    protected $table = 'refeicoes';

    public function __construct()
    {
        parent::__construct();
    }


    public function showForm()
    {
        // Verifica se o usuário é um nutricionista logado
        if (!isset($_SESSION['nutri_id']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['tipo' => 'danger', 'texto' => 'Acesso não autorizado.']);
        }
        
        // Carrega o arquivo HTML do formulário
        view('receitas/formulario');
    }

    public function save()
    {
        // Segurança: Verifica novamente se o usuário pode realizar esta ação
        if (!isset($_SESSION['nutricionista_id']) || $_SESSION['user_tipo'] !== 'nutricionista') {
            redirectPage(base_url('login'), ['tipo' => 'danger', 'texto' => 'Ação não autorizada.']);
        }

        // Instancia os objetos de banco de dados
        $db_alimentos = new \Models\Database('alimentos');
        $db_refeicao_alimentos = new \Models\Database('refeicao_alimentos');

        $pdo = $this->connection->getConnection(); // Pega o objeto PDO
        $pdo->beginTransaction();

        try {
            // 1. PROCESSAMENTO DO UPLOAD DA IMAGEM
            $caminho_imagem = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $pasta_uploads = __DIR__ . '/../../public/uploads/receitas/'; // Corrigido para apontar para a pasta public
                if (!is_dir($pasta_uploads)) {
                    mkdir($pasta_uploads, 0777, true);
                }
                $nome_arquivo = uniqid() . '-' . basename($_FILES['foto']['name']);
                $caminho_completo = $pasta_uploads . $nome_arquivo;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_completo)) {
                    $caminho_imagem = 'public/uploads/receitas/' . $nome_arquivo;
                } else {
                    throw new \Exception("Falha ao mover o arquivo de imagem.");
                }
            }

            // 2. SALVAR A RECEITA PRINCIPAL
            $dados_refeicao = [
                'nome' => $_POST['nome'],
                'descricao' => $_POST['detalhes'],
                'modo_preparo' => $_POST['passoAPasso'],
                'observacoes' => $_POST['observacoes'],
                'tempo_preparo_min' => $_POST['tempoPreparo'],
                'rendimento_porcoes' => $_POST['porcoes'],
                'tipo_refeicao_id' => $_POST['tipo_refeicao_id'],
                'nutricionista_criador_id' => $_SESSION['nutricionista_id'],
                'imagem_url' => $caminho_imagem
            ];
            
            // Usa o método insert() herdado da classe Crud
            $novaRefeicaoId = $this->insert($dados_refeicao);

            if (!$novaRefeicaoId) {
                throw new \Exception("Falha ao salvar os dados principais da receita.");
            }

            // 3. SALVAR OS INGREDIENTES
            $nomes_ingredientes = $_POST['ingrediente_nome'];
            $qtds_ingredientes = $_POST['ingrediente_qtd'];
            $unidades_ingredientes = $_POST['ingrediente_unidade'];

            foreach ($nomes_ingredientes as $index => $nome_ingrediente) {
                if (!empty($nome_ingrediente)) {
                    // Lógica "Find or Create"
                    $alimento = $db_alimentos->select('nome = :nome', [':nome' => $nome_ingrediente])->fetch(PDO::FETCH_OBJ);
                    $alimentoId = $alimento ? $alimento->id : $db_alimentos->insert(['nome' => $nome_ingrediente]);

                    $db_refeicao_alimentos->insert([
                        'refeicao_id' => $novaRefeicaoId,
                        'alimento_id' => $alimentoId,
                        'quantidade' => $qtds_ingredientes[$index],
                        'unidade' => $unidades_ingredientes[$index]
                    ]);
                }
            }

            // 4. FINALIZAR A TRANSAÇÃO
            $pdo->commit();
            redirectPage(base_url('nutricionista/dashboard'), ['tipo' => 'success', 'texto' => 'Receita cadastrada com sucesso!']);

        } catch (\Exception $e) {
            // 5. SE ALGO DEU ERRADO, DESFAZ TUDO
            $pdo->rollBack();
            redirectPage(base_url('receitas/novo'), ['tipo' => 'danger', 'texto' => 'Erro ao cadastrar receita: ' . $e->getMessage()]);
        }
    }
}