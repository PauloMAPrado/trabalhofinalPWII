<?php

//apelido do arquivo (Alias)
namespace Models;

// faz a chamada da classe PDO
use \PDO;
use \PDOException;

class Database{

  # Host de conexão com o banco de dados
  const HOST = 'mysql';
  
  # Nome do banco de dados
  const NAME = 'projeto';

  # Usuário do banco
  const USER = 'aluno';

  # Senha de acesso ao banco de dados
  const PASS = '123456';

  const PORT = '3306';


  # Nome da tabela a ser manipulada
  private $table;

  # Instancia de conexão com o banco de dados
  private $connection;

  # Define a tabela e instancia e conexão
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  # Método responsável por criar uma conexão com o banco de dados
  private function setConnection(){
    try{
      $this->connection = new PDO(
        'mysql:host=mysql;port=3306;dbname=projeto;charset=utf8',
        'aluno',
        '123456'
    );

      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  # Método responsável por executar queries dentro do banco de dados
  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }


  public function insert($values){
    //Extração de chaves e valores do array
    $fields = array_keys($values); // pega as chaves do array
    $binds  = array_pad([],count($fields),'?'); // cria as posições de inserção da query

    //monta a query de inserção
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    
    //executa a query e passa o valores que serão inseridos no banco
    $this->execute($query,array_values($values));

    //retorna o ultimo id inserido.
    return $this->connection->lastInsertId();
  }

 
  public function select($join = null, $where = null, $order = null, $limit = null,$fields = '*'){
    
    //Complementos da query de seleção
    @$join = strlen($join) ? 'inner join '.$join : ''; //junção de tabelas
    @$where = strlen($where) ? 'WHERE '.$where : ''; //clausula where
    @$order = strlen($order) ? 'ORDER BY '.$order : ''; //ordenação
    @$limit = strlen($limit) ? 'LIMIT '.$limit : ''; // limite de retorno de dados

    //monta a query
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$join.' '.$where.' '.$order.' '.$limit;
    
    //Executa a query
    return $this->execute($query);
  }

  
  public function update($where,$values){
    //Dados da query
    $fields = array_keys($values);

    //Monta a query
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    
    //EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  public function delete($where){
    //Monta a query
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
    
    //Executa a query
    $this->execute($query);
    
    //Retorna verdadeiro caso tenha sucesso na exclusão
    return true;
  }

}

$table = 'cidades';
$con = new Database($table);


// # R - Read
$read = ($con)->select()->fetchAll(PDO::FETCH_OBJ);
var_dump($read);

