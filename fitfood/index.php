<?php
session_start();
require_once 'Config/Helpers.php';

spl_autoload_register(function($class_name) {
    $file = str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$routes = require_once 'Config/Routes.php';

$request_uri = '/' . ($_GET['url'] ?? '');
$request_method = $_SERVER['REQUEST_METHOD'];
$matched_route = null;
$params = [];

if (isset($routes[$request_method])) {
    foreach ($routes[$request_method] as $route => $handler) {
        $pattern = preg_replace('/\\{([a-zA-Z0-9_]+)\\}/', '([a-zA-Z0-9_]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $request_uri, $matches)) {
            array_shift($matches);
            $params = $matches;
            $matched_route = $handler;
            break;
        }
    }
}

if ($matched_route) {
    $controllerName = 'Controllers\\' . $matched_route[0];
    $methodName = $matched_route[1];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        } else {
            echo "Erro 404: Método '{$methodName}' não encontrado.";
        }
    } else {
        echo "Erro 404: Controller '{$controllerName}' não encontrado.";
    }
} else {
    // Debug: mostrar qual rota foi tentada
    if ($request_uri === '/') {
        // Redireciona para login se não há rota raiz
        header('Location: /login');
        exit;
    }
    
    http_response_code(404);
    echo "Rota não encontrada: {$request_uri}";
}
