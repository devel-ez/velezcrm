<?php
require_once __DIR__ . '/../config/config.php';
use App\Database\Database;

try {
    $db = Database::getInstance();
    
    // Primeiro, vamos garantir que existe pelo menos um cliente
    $sql = "INSERT IGNORE INTO clientes (nome, email, telefone) VALUES ('Cliente Teste', 'teste@email.com', '(11) 99999-9999')";
    $db->exec($sql);
    $cliente_id = $db->lastInsertId() ?: 1; // Pega o ID do cliente inserido ou usa 1 se já existia
    
    // Agora vamos inserir um contrato de teste
    $sql = "INSERT INTO contratos (titulo, cliente_id, descricao, valor, status) 
            VALUES ('Contrato de Teste', :cliente_id, 'Descrição do contrato de teste', 1000.00, 'ativo')";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([':cliente_id' => $cliente_id]);
    
    echo "Contrato de teste criado com sucesso!";
    
} catch (Exception $e) {
    echo "Erro ao criar contrato de teste: " . $e->getMessage();
}
