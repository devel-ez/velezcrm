<?php
require_once __DIR__ . '/../config/config.php';

// Função para autoload de classes
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $file = BASE_PATH . DIRECTORY_SEPARATOR . $file;
    if (file_exists($file)) {
        require_once $file;
    }
});

// Tratamento da URL
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Verifica autenticação
if (!isset($_SESSION['user_id']) && $url[0] !== 'auth') {
    header('Location: ' . APP_URL . '/auth');
    exit;
}

// Define o controller
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$controllerName = "App\\Http\\Controllers\\" . $controllerName;

// Define a ação
$actionName = isset($url[1]) ? $url[1] : 'index';

// Define os parâmetros
$params = array_slice($url, 2);

// Verifica se o controller existe
if (!class_exists($controllerName)) {
    header("HTTP/1.0 404 Not Found");
    require_once VIEW_PATH . '/errors/404.php';
    exit;
}

// Instancia o controller
$controller = new $controllerName();

// Verifica se o método existe
if (!method_exists($controller, $actionName)) {
    header("HTTP/1.0 404 Not Found");
    require_once VIEW_PATH . '/errors/404.php';
    exit;
}

// Chama o método do controller com os parâmetros
call_user_func_array([$controller, $actionName], $params);
