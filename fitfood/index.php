<?php
// fitfood/index.php

// Inicia a sessão para todas as requisições
session_start();

// Carrega o arquivo de funções de ajuda
require_once 'Config/Helpers.php';

// AUTOLOADER: Carrega as classes automaticamente quando são necessárias
spl_autoload_register(function ($class_name) {
    // Converte o namespace\classe para um caminho de arquivo (ex: Controllers\NutricionistaController -> Controllers/NutricionistaController.php)
    $file = str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Carrega o array de rotas do nosso mapa
$routes = require_once 'Routes.php';

// Pega a URL "amigável" da requisição. Ex: /pacientes/editar/15
$request_uri = '/' . ($_GET['url'] ?? '');
// Pega o método da requisição (GET ou POST)
$request_method = $_SERVER['REQUEST_METHOD'];

$matched_route = null;
$params = [];

// Procura a rota no array de rotas do método correspondente (GET ou POST)
if (isset($routes[$request_method])) {
    foreach ($routes[$request_method] as $route => $handler) {
        // Converte a rota em um padrão de Expressão Regular para lidar com parâmetros como {id}
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $request_uri, $matches)) {
            array_shift($matches);
            $params = $matches;
            $matched_route = $handler;
            break;
        }
    }
}

// Se encontrou uma rota correspondente, chama o controller
if ($matched_route) {
    $controllerName = 'Controllers\\' . $matched_route[0];
    $methodName = $matched_route[1];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            // Chama o método, passando os parâmetros da URL (como o ID)
            call_user_func_array([$controller, $methodName], $params);
        } else {
            echo "Erro 404: Método '{$methodName}' não encontrado.";
        }
    } else {
        echo "Erro 404: Controller '{$controllerName}' não encontrado.";
    }
} else {
    // Se não encontrou nenhuma rota, exibe a página 404
    http_response_code(404);
    view('erros/404'); // Cria um arquivo em Views/erros/404.php
}