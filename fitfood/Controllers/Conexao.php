<?php

$servername = "localhost"; // OU 127.0.0.1
$username = "root";
$password = "123456789";
$dbname = "fitfood";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>