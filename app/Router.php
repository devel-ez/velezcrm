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
        
        // Procura por uma rota que corresponda ao padrão
        foreach ($this->routes[$method] ?? [] as $routePath => $callback) {
            $params = $this->matchRoute($path, $routePath);
            
            if ($params !== false) {
                if (is_string($callback)) {
                    list($controller, $method) = explode('@', $callback);
                    $controllerClass = "App\\Controllers\\{$controller}";
                    $controllerFile = __DIR__ . '/Controllers/' . $controller . '.php';
                    
                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        $controller = new $controllerClass();
                        
                        // Remove o match completo
                        unset($params[0]);
                        
                        // Chama o método do controller com os parâmetros
                        call_user_func_array([$controller, $method], $params);
                        return;
                    }
                }
            }
        }
        
        // Se nenhuma rota for encontrada
        $this->renderError(404);
    }
    
    private function renderError($code) {
        http_response_code($code);
        require __DIR__ . '/../views/errors/' . $code . '.php';
        exit;
    }
}
