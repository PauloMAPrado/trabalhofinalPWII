<?php
namespace Config;

use Models\Database;

class Crud {
    protected $db;
    protected $table;

    public function __construct() {
        if ($this->table) {
            $this->db = new Database($this->table);
        }
    }

    public function insert($data) {
        return $this->db->insert($data);
    }

    public function select($where = null, $params = []) {
        return $this->db->select($where, $params);
    }

    public function update($where, $params, $data) {
        return $this->db->update($where, $params, $data);
    }

    public function delete($where, $params = []) {
        return $this->db->delete($where, $params);
    }
}