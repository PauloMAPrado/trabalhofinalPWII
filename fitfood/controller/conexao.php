<?php
$conn = new mysqli("127.0.0.1", "root", "123456789", "fitfood");

if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>