<?php
class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    private function matchRoute($requestPath, $routePath)
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $requestPath, $matches)) {
            error_log("🚀 Parâmetros capturados: " . print_r($matches, true));

            // Ajusta a captura para passar apenas os valores corretos
            $filteredParams = [];
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $filteredParams[$key] = $value;
                }
            }

            return $filteredParams;
        }

        return false;
    }



    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove "/velezcrm/index.php" e "/velezcrm/public" para evitar erros
        $basePath = '/velezcrm';
        $path = str_replace([$basePath . '/index.php', $basePath . '/public', $basePath], '', $path);
        $path = $path ?: '/';

        error_log("Método: " . $method);
        error_log("Caminho requisitado: " . $path);

        // Procura por uma rota correspondente
        foreach ($this->routes[$method] ?? [] as $routePath => $callback) {
            error_log("Tentando corresponder rota: " . $routePath);
            $params = $this->matchRoute($path, $routePath);

            if ($params !== false) {
                error_log("📌 Parâmetros finais passados: " . print_r($params, true));

                if (is_string($callback)) {
                    list($controller, $method) = explode('@', $callback);
                    $controllerClass = "App\\Controllers\\{$controller}";
                    $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';

                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;

                        if (class_exists($controllerClass)) {
                            $controller = new $controllerClass();

                            if (method_exists($controller, $method)) {
                                error_log("🔹 Chamando método: $method com parâmetros: " . print_r(array_values($params), true));
                                call_user_func_array([$controller, $method], array_values($params)); // Aqui garantimos que os parâmetros estão corretos
                                return;
                            }
                        }
                    }
                }
            }
        }

        // Se nenhuma rota for encontrada
        error_log("Nenhuma rota encontrada para: " . $path);
        header("HTTP/1.0 404 Not Found");
        echo "Página não encontrada";
        exit();
    }
}

// Instancia o Router
$router = new Router();

// Rotas do Dashboard
$router->get('/', 'DashboardController@index');
$router->get('/dashboard', 'DashboardController@index');


// Rotas de Clientes
$router->get('/clientes', 'ClienteController@index');
$router->get('/clientes/novo', 'ClienteController@novo');
$router->post('/clientes/salvar', 'ClienteController@salvar');
$router->get('/clientes/editar/{id}', 'ClienteController@editar');
$router->get('/clientes/excluir/{id}', 'ClienteController@excluir');
$router->get('/clientes/visualizar/{id}', 'ClienteController@visualizar');


// Rotas de Serviços
$router->get('/servicos', 'ServicoController@index');
$router->get('/servicos/novo', 'ServicoController@novo');
$router->post('/servicos/salvar', 'ServicoController@salvar');
$router->get('/servicos/editar/{id}', 'ServicoController@editar');
$router->get('/servicos/excluir/{id}', 'ServicoController@excluir');

// Rotas de Contratos
$router->get('/contratos', 'ContratoController@index');
$router->get('/contratos/criar', 'ContratoController@criar');
$router->post('/contratos/salvar', 'ContratoController@salvar');
$router->get('/contratos/editar/{id}', 'ContratoController@editar');
$router->get('/contratos/excluir/{id}', 'ContratoController@excluir');
$router->get('/contratos/novo', 'ContratoController@novo');
$router->post('/contratos/novo', 'ContratoController@salvar');

// Rotas do Kanban
$router->get('/kanban', 'KanbanController@index');
$router->get('/kanban/getCards/{id}', 'KanbanController@getCards');
$router->post('/kanban/createCard', 'KanbanController@createCard');
$router->post('/kanban/updateCardStatus', 'KanbanController@updateCardStatus');
$router->get('/kanban/getCard/{id}', 'KanbanController@getCard'); // Busca um card específico
$router->post('/kanban/editCard', 'KanbanController@editCard'); // Edita um card existente
$router->post('/kanban/deleteCard', 'KanbanController@deleteCard'); // Exclui um card


//Rotas de Login
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
