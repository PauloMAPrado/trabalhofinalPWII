<?php

namespace Models;

use \PDO;
use \PDOException;

class Database {

    const HOST = 'mysql'; 
    
    const NAME = 'fitfood'; 

    const USER = 'aluno'; 

    const PASS = '123456'; 

    const PORT = '3306';

    private $table;

    private $connection;

    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection(){
        try {
            $dsn = 'mysql:host=' . self::HOST . ';port=' . self::PORT . ';dbname=' . self::NAME . ';charset=utf8';
            $this->connection = new PDO($dsn, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
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

        $query = 'SELECT '.$fields.' FROM `'.$this->table.'` '.$whereClause.' '.$orderClause.' '.$limitClause;
        
        return $this->execute($query, $params);
    }
  
    
    public function update($where, $paramsWhere, $values){
        $fields = array_keys($values);
        $fieldsForQuery = implode(' = ?, ', $fields) . ' = ?';

        $query = 'UPDATE `'.$this->table.'` SET '.$fieldsForQuery.' WHERE '.$where;
        
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

