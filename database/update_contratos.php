<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    // Adiciona as novas colunas à tabela contratos
    $sql = "ALTER TABLE contratos 
            ADD COLUMN numero_contrato VARCHAR(20) AFTER id,
            ADD COLUMN data_validade DATE AFTER status,
            ADD COLUMN objeto TEXT AFTER titulo,
            ADD COLUMN ano_contrato INT GENERATED ALWAYS AS (YEAR(created_at)) STORED AFTER numero_contrato;";
    
    $db->exec($sql);
    echo "Tabela de contratos atualizada com sucesso!\n";
    
    // Atualiza os contratos existentes com número do contrato
    $sql = "UPDATE contratos 
            SET numero_contrato = CONCAT(id, '/', YEAR(created_at))
            WHERE numero_contrato IS NULL;";
    
    $db->exec($sql);
    echo "Números dos contratos atualizados com sucesso!\n";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
