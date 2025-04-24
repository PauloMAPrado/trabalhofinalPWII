<?php
class Paciente {
    private $conn;
    private $table = 'pacientes';

    public $id;
    public $nome;
    public $dt_nasc;
    public $altura;
    public $peso;
    public $imc;
    public $email;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET nome = :nome, 
                      dt_nasc = :dt_nasc, 
                      altura = :altura, 
                      peso = :peso, 
                      imc = :imc, 
                      email = :email, 
                      senha = :senha";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->dt_nasc = htmlspecialchars(strip_tags($this->dt_nasc));
        $this->altura = floatval($this->altura);
        $this->peso = floatval($this->peso);
        $this->imc = floatval($this->imc);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->senha = password_hash($this->senha, PASSWORD_BCRYPT);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':dt_nasc', $this->dt_nasc);
        $stmt->bindParam(':altura', $this->altura);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':imc', $this->imc);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        
        $num = $stmt->rowCount();
        
        return $num > 0;
    }
}
?>