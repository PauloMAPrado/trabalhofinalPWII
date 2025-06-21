<?php

/**
 * Carrega o menu de navegação correto com base no tipo de usuário logado.
 * Os menus devem corresponder aos tipos de usuário definidos na sessão.
 * 
 * @param string $tipoUsuario O tipo de usuário (ex: 'nutricionista', 'paciente', 'visitante').
 */
function accessNavigate($tipoUsuario = 'visitante')
{
    switch ($tipoUsuario) {
        case 'nutricionista':
            include_once(__DIR__ . '/../Views/templates/nav_nutricionista.php');
            break;
        case 'paciente':
            include_once(__DIR__ . '/../Views/templates/nav_paciente.php');
            break;
        default:
            include_once(__DIR__ . '/../Views/templates/nav_visitante.php');
            break;
    }
}

/**
 * Carrega um arquivo de View e passa um array de dados para ele.
 * A função extract() cria variáveis locais a partir das chaves do array.
 * 
 * @param string $viewName O nome da view a ser carregada.
 * @param array $data Os dados a serem passados para a view.
 */
function view($viewName, $data = [])
{
    $viewPath = __DIR__ . "/../Views/{$viewName}.php";

    if (file_exists($viewPath)) {
        extract($data);
        include $viewPath;
    } else {
        echo "Erro: View '{$viewName}' não encontrada!";
    }
}

/**
 * Gera uma URL absoluta completa para qualquer caminho dentro do projeto.
 * Essencial para que links, CSS e JS funcionem corretamente.
 * 
 * @param string $path O caminho a ser adicionado à URL base.
 * @return string A URL completa.
 */
function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $url = rtrim($protocol . "://" . $host . $scriptName, '/');

    return $url . '/' . ltrim($path, '/');
}

/**
 * Redireciona o usuário para uma nova página e, opcionalmente,
 * define uma "mensagem flash" que pode ser exibida na página de destino.
 * 
 * @param string $path A URL completa para onde o usuário será redirecionado.
 * @param array|null $message A mensagem a ser armazenada na sessão.
 */
function redirectPage($path, $message = null) {
    if ($message) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['msg'] = $message;
    }
    
    header("Location: {$path}");
    exit();
}
