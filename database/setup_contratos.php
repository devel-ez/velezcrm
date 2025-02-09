<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    $sql = "CREATE TABLE IF NOT EXISTS contratos (
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
    echo "Tabela de contratos criada/atualizada com sucesso!\n";
    
} catch (Exception $e) {
    echo "Erro ao criar tabela de contratos: " . $e->getMessage() . "\n";
}
