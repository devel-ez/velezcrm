<?php
// Importação de namespaces
use App\Database\Database;

// Configurações do Banco de Dados2
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'u355084043_921xC');
define('DB_PASS', 'Citex5050@');
define('DB_NAME', 'u355084043_vhEjy');

// Configurações do Banco de Dados2
/*define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'velezcrm');*/

// Obtém o protocolo (http ou https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Obtém o nome do host atual
$host = $_SERVER['HTTP_HOST'];

// Define a BASE_URL dinamicamente
define('BASE_URL', $protocol . '://' . $host . '/velezcrm');

// Configurações de timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define o caminho base das views
define('VIEWS_PATH', __DIR__ . '/../views');

// Autoload de classes
spl_autoload_register(function ($class) {
    // Converte o namespace em caminho de arquivo
    $prefix = '';
    $base_dir = __DIR__ . '/../';

    $file = $base_dir . str_replace('\\', '/', $class) . '.php';
    
    // Debug
    error_log("Tentando carregar classe: " . $class);
    error_log("Arquivo: " . $file);
    
    // Se o arquivo existir, carrega-o
    if (file_exists($file)) {
        require_once $file;
        error_log("Classe carregada com sucesso: " . $class);
        return true;
    }
    error_log("Arquivo não encontrado: " . $file);
    return false;
});

try {
    // Inicializa a conexão com o banco de dados
    require_once __DIR__ . '/../app/Database/Database.php';
    
    global $db;
    $db = Database::getInstance();
    error_log("Conexão com o banco de dados estabelecida com sucesso!");
} catch (\Exception $e) {
    error_log("Erro ao conectar com o banco de dados: " . $e->getMessage());
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
