<?php
// Exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carrega as configurações
require_once __DIR__ . '/../config/config.php';

// Tenta executar uma consulta simples
try {
    global $db;
    $result = $db->query("SHOW TABLES")->fetchAll();
    echo "Conexão estabelecida com sucesso!\n";
    echo "Tabelas encontradas:\n";
    foreach ($result as $row) {
        echo "- " . $row[0] . "\n";
    }
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
