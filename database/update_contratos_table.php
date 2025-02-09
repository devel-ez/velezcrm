<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    // Array com as alterações necessárias
    $alteracoes = [
        "ADD COLUMN IF NOT EXISTS numero_contrato VARCHAR(20) AFTER id",
        "ADD COLUMN IF NOT EXISTS objeto TEXT AFTER cliente_id",
        "ADD COLUMN IF NOT EXISTS clausulas TEXT AFTER objeto",
        "ADD COLUMN IF NOT EXISTS data_validade DATE AFTER clausulas",
        "MODIFY COLUMN valor DECIMAL(10,2) NOT NULL DEFAULT 0.00",
        "MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'ativo'"
    ];
    
    // Executa cada alteração
    foreach ($alteracoes as $alteracao) {
        try {
            $sql = "ALTER TABLE contratos $alteracao";
            $db->exec($sql);
            echo "Alteração executada com sucesso: $alteracao\n";
        } catch (\Exception $e) {
            echo "Aviso ao executar alteração ($alteracao): " . $e->getMessage() . "\n";
            // Continua com as próximas alterações mesmo se uma falhar
        }
    }
    
    // Verifica se a tabela de relacionamento contratos_servicos existe
    $sql = "CREATE TABLE IF NOT EXISTS contratos_servicos (
        contrato_id INT NOT NULL,
        servico_id INT NOT NULL,
        PRIMARY KEY (contrato_id, servico_id),
        FOREIGN KEY (contrato_id) REFERENCES contratos(id) ON DELETE CASCADE,
        FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $db->exec($sql);
    echo "Tabela contratos_servicos verificada/criada com sucesso!\n";
    
    echo "Atualização da estrutura do banco de dados concluída!\n";
    
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
