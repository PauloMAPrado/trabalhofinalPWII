<?php
if(!isset($params[0])){
    $id = Null;
}else{
    $id = $params[0];
}
echo "<h1>Perfil do Usuário</h1>";
echo "<p>ID do usuário: <strong>$id</strong></p>";
