<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    // Verifica e adiciona a coluna objeto se não existir
    $db->exec("
        SET @exists = 0;
        SELECT COUNT(*) INTO @exists FROM information_schema.columns 
        WHERE table_schema = DATABASE() 
        AND table_name = 'contratos' 
        AND column_name = 'objeto';
        
        SET @sql = IF(@exists = 0,
            'ALTER TABLE contratos ADD COLUMN objeto TEXT AFTER titulo',
            'SELECT \"Coluna objeto já existe\"');
        
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
    ");
    
    // Verifica e adiciona a coluna data_validade se não existir
    $db->exec("
        SET @exists = 0;
        SELECT COUNT(*) INTO @exists FROM information_schema.columns 
        WHERE table_schema = DATABASE() 
        AND table_name = 'contratos' 
        AND column_name = 'data_validade';
        
        SET @sql = IF(@exists = 0,
            'ALTER TABLE contratos ADD COLUMN data_validade DATE AFTER status',
            'SELECT \"Coluna data_validade já existe\"');
        
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
    ");
    
    echo "Script executado com sucesso!\n";
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
