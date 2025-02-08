<?php
// Carrega as variáveis de ambiente se o arquivo .env existir
if (file_exists(__DIR__ . '/../.env')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

// Configurações do Banco de Dados
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'velezcrm');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// Configurações da Aplicação
define('APP_NAME', $_ENV['APP_NAME'] ?? 'VelezCRM');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost/velezcrm');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Configurações de Diretórios
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/Views');
define('CONTROLLER_PATH', APP_PATH . '/Controllers');
define('MODEL_PATH', APP_PATH . '/Models');

// Configuração de Timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurações de Sessão
session_start();

// Configuração de Exibição de Erros
if ($_ENV['APP_ENV'] ?? 'development' === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
