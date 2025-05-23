<?php
// $params[0] conterá o ID do produto
if(!isset($params[0])){
    $id = Null;
}else{
    $id = $params[0];
}
echo "<h1>Detalhes do Produto</h1>";
echo "<p>Você está vendo o produto com ID: <strong>$id</strong></p>";
