<?php


ob_start(); // <- Inicia o buffer de saída
session_start(); // <- Isso é essencial para usar $_SESSION


include_once 'Config/Helpers.php';
include_once 'Autoloader.php';


include('Views/templates/header.php');

// Verificar qual menu de navegação irá carregar
// visitante: carrega o nav.php
// 0: acessa o nível de usuário cliente
// 1: acessa o nível de administrador

if(isset($_SESSION['usuario_logado'])){
    $nivel = $_SESSION['usuario_logado']->usuarios_nivel;
    echo accessNavigate($nivel);
}else{
    echo accessNavigate();
}

// Carrega as rotas
$routes = require __DIR__ . '/Config/Routes.php';

// Pega URI atual
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';


// Função para fazer match de rota com parâmetro
function matchRoute($uri, $routes)
{
    foreach ($routes as $route => $handler) {
        // Converte rota para regex (ex: /user/{id} → \/user\/([^\/]+))
        $pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
        $pattern = "#^" . rtrim($pattern, '/') . "$#";

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove o match completo
            return [$handler, $matches];
        }
    }
    return [null, []];
}

// Faz o match
[$handler, $params] = matchRoute($uri, $routes);

if ($handler) {
    [$controllerName, $method] = $handler;
    $name = "\\Controllers\\".$controllerName;
    $controller = new $name();

    if(class_exists($name)) {
        

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(404);
            echo "Método '{$method}' não encontrado em {$controllerName}.";
        }
    } else {
        http_response_code(404);
        echo "Controller '{$controllerName}' não encontrado.";
    }
} else {
    http_response_code(404);
    echo "Rota '{$uri}' não encontrada.";
}
include('Views/templates/footer.php');
include('Views/templates/end.php');
ob_end_flush(); // <- Libera o conteúdo do buffer