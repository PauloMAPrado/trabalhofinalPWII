   <?php

   $servername = "localhost"; // OU 127.0.0.1
   $username = "aluno"; // Verifique se este usuário tem acesso ao banco de dados
   $password = "123456"; // Verifique se a senha está correta
   $dbname = "fitfood"; // Nome do banco de dados

   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
       // Configurar o modo de erro do PDO para exceções
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
       die("Falha na conexão: " . $e->getMessage());
   }

   // Opcional: Retornar a conexão para uso posterior
   return $conn;
   