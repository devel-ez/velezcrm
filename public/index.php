<?php
// Exibição detalhada de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão
session_start();

// Define o diretório base
define('BASE_DIR', dirname(__DIR__));

// Carrega o autoloader
require_once BASE_DIR . '/vendor/autoload.php';

// Carrega as configurações
require_once BASE_DIR . '/config/config.php';

// Carrega o Router
require_once BASE_DIR . '/app/Router.php';

// Carrega o Controller base
require_once BASE_DIR . '/app/Controllers/Controller.php';

// Inicializa o router
$router = new Router();

// Define as rotas
$router->get('/', 'DashboardController@index');

// Rotas de Clientes
$router->get('/clientes', 'ClienteController@index');
$router->get('/clientes/novo', 'ClienteController@novo');
$router->post('/clientes/salvar', 'ClienteController@salvar');
$router->get('/clientes/editar/{id}', 'ClienteController@editar');
$router->get('/clientes/visualizar/{id}', 'ClienteController@visualizar');
$router->get('/clientes/excluir/{id}', 'ClienteController@excluir');

// Rotas de Serviços
$router->get('/servicos', 'ServicoController@index');
$router->get('/servicos/novo', 'ServicoController@novo');
$router->post('/servicos/salvar', 'ServicoController@salvar');
$router->get('/servicos/editar/{id}', 'ServicoController@editar');
$router->get('/servicos/excluir/{id}', 'ServicoController@excluir');

// Rotas de Contratos
$router->get('/contratos', 'ContratoController@index');
$router->get('/contratos/novo', 'ContratoController@novo');
$router->post('/contratos/salvar', 'ContratoController@salvar');
$router->get('/contratos/editar/{id}', 'ContratoController@editar');
$router->get('/contratos/excluir/{id}', 'ContratoController@excluir');

$router->get('/kanban', 'KanbanController@index');
$router->get('/configuracoes', 'ConfiguracaoController@index');

// Executa o router
try {
    $router->dispatch();
} catch (Exception $e) {
    error_log("Erro na aplicação: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo "Erro na aplicação. Por favor, verifique os logs para mais detalhes.";
}
