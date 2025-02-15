<?php
session_start();
require_once __DIR__ . '/config/config.php'; // Carrega as configurações do projeto
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Router.php';

// Executa o roteador para despachar a requisição
$router->dispatch();
