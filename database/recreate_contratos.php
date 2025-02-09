<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    // Desabilita verificação de chaves estrangeiras temporariamente
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Drop da tabela se existir
    $db->exec("DROP TABLE IF EXISTS contratos");
    
    // Criação da tabela com todas as colunas necessárias
    $sql = "CREATE TABLE contratos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        cliente_id INT NOT NULL,
        descricao TEXT,
        valor DECIMAL(10,2),
        status VARCHAR(50) DEFAULT 'ativo',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $db->exec($sql);
    echo "Tabela de contratos recriada com sucesso!\n";
    
    // Reabilita verificação de chaves estrangeiras
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    // Inserir um contrato de teste
    $sql = "INSERT INTO contratos (titulo, cliente_id, descricao, valor, status) 
            SELECT 'Contrato de Teste', id, 'Descrição do contrato de teste', 1000.00, 'ativo'
            FROM clientes LIMIT 1";
    
    $db->exec($sql);
    echo "Contrato de teste inserido com sucesso!\n";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    // Em caso de erro, garante que as chaves estrangeiras sejam reabilitadas
    try {
        $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    } catch (Exception $e2) {
        echo "Erro ao reabilitar chaves estrangeiras: " . $e2->getMessage() . "\n";
    }
}
