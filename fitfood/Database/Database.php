<?php

// Apelido do arquivo (Alias)
namespace Models;

// Faz a chamada da classe PDO
use \PDO;
use \PDOException;

class Database {

    # Host de conexão com o banco de dados
    const HOST = 'mysql'; // ou 'localhost' na maioria dos ambientes de desenvolvimento
    
    # Nome do banco de dados
    const NAME = 'fitfood'; // O nome correto do seu banco

    # Usuário do banco
    const USER = 'aluno'; // Seu usuário

    # Senha de acesso ao banco de dados
    const PASS = '123456'; // Sua senha

    # Porta
    const PORT = '3306';

    # Nome da tabela a ser manipulada
    private $table;

    # Instância de conexão com o banco de dados
    private $connection;

    # Define a tabela e instancia a conexão
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

    # Método responsável por criar uma conexão com o banco de dados
    private function setConnection(){
        try {
            // CORREÇÃO: Usando as constantes da classe para criar a conexão
            $dsn = 'mysql:host=' . self::HOST . ';port=' . self::PORT . ';dbname=' . self::NAME . ';charset=utf8';
            $this->connection = new PDO($dsn, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Em produção, evite expor detalhes do erro. Grave em um log.
            die('ERRO DE CONEXÃO: ' . $e->getMessage());
        }
    }

    
    private function execute($query, $params = []){
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERRO DE EXECUÇÃO: ' . $e->getMessage());
        }
    }

    public function insert($values){
        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $query = 'INSERT INTO `'.$this->table.'` ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';
        
        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }
 
    public function select($where = null, $params = [], $order = null, $limit = null, $fields = '*'){
        $whereClause = !empty($where) ? 'WHERE ' . $where : '';
        $orderClause = !empty($order) ? 'ORDER BY ' . $order : '';
        $limitClause = !empty($limit) ? 'LIMIT ' . $limit : '';

        // Monta a query
        $query = 'SELECT '.$fields.' FROM `'.$this->table.'` '.$whereClause.' '.$orderClause.' '.$limitClause;
        
        return $this->execute($query, $params);
    }
  
    
    public function update($where, $paramsWhere, $values){
        $fields = array_keys($values);
        $fieldsForQuery = implode(' = ?, ', $fields) . ' = ?';

        $query = 'UPDATE `'.$this->table.'` SET '.$fieldsForQuery.' WHERE '.$where;
        
        // Combina os valores do SET e do WHERE para o execute
        $all_params = array_merge(array_values($values), $paramsWhere);
        $statement = $this->execute($query, $all_params);

        return $statement->rowCount();
    }

   
    public function delete($where, $params = []){
        $query = 'DELETE FROM `'.$this->table.'` WHERE '.$where;
        
        $statement = $this->execute($query, $params);
        
        return $statement->rowCount();
    }
}

