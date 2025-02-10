<?php
class Router {
    private $routes = [];
    
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    
    private function matchRoute($requestPath, $routePath) {
        // Converte o padrão da rota em uma expressão regular
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $requestPath, $matches)) {
            // Remove as chaves numéricas do array de matches
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }
        
        return false;
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = str_replace('/velezcrm', '', $path);
        $path = $path ?: '/';
        
        error_log("Método: " . $method);
        error_log("Caminho requisitado: " . $path);
        
        // Procura por uma rota que corresponda ao padrão
        foreach ($this->routes[$method] ?? [] as $routePath => $callback) {
            error_log("Tentando corresponder rota: " . $routePath);
            $params = $this->matchRoute($path, $routePath);
            
            if ($params !== false) {
                error_log("Rota encontrada: " . $routePath);
                if (is_string($callback)) {
                    list($controller, $method) = explode('@', $callback);
                    $controllerClass = "App\\Controllers\\{$controller}";
                    $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';
                    
                    error_log("Arquivo do controller: " . $controllerFile);
                    error_log("Classe do controller: " . $controllerClass);
                    
                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        
                        if (class_exists($controllerClass)) {
                            $controller = new $controllerClass();
                            
                            if (method_exists($controller, $method)) {
                                // Remove o match completo
                                unset($params[0]);
                                
                                // Chama o método do controller com os parâmetros
                                call_user_func_array([$controller, $method], $params);
                                return;
                            } else {
                                error_log("Método {$method} não encontrado na classe {$controllerClass}");
                                throw new \Exception("Método não encontrado");
                            }
                        } else {
                            error_log("Classe {$controllerClass} não encontrada");
                            throw new \Exception("Classe do controller não encontrada");
                        }
                    } else {
                        error_log("Arquivo {$controllerFile} não encontrado");
                        throw new \Exception("Arquivo do controller não encontrado");
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

// Rotas de Clientes
$router->get('/clientes', 'ClienteController@index');
$router->get('/clientes/novo', 'ClienteController@novo');
$router->post('/clientes/salvar', 'ClienteController@salvar');
$router->get('/clientes/editar/{id}', 'ClienteController@editar');
$router->get('/clientes/excluir/{id}', 'ClienteController@excluir');

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

// Rotas do Kanban
$router->get('/kanban', 'KanbanController@index');
