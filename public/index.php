<?php
session_start();

// Carrega as configurações
require_once __DIR__ . '/../config/config.php';

// Carrega o Router
require_once __DIR__ . '/../app/Router.php';

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

// Outras rotas
$router->get('/servicos', 'ServicoController@index');
$router->get('/contratos', 'ContratoController@index');
$router->get('/kanban', 'KanbanController@index');
$router->get('/configuracoes', 'ConfiguracaoController@index');

// Executa o router
$router->dispatch();
