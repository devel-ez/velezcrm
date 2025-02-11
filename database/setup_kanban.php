<?php

require_once __DIR__ . '/../config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );

    // Criar tabela kanban_cards
    $sql = "CREATE TABLE IF NOT EXISTS kanban_cards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT,
        status ENUM('backlog', 'todo', 'doing', 'done') DEFAULT 'backlog',
        posicao INT DEFAULT 0,
        data_criacao DATETIME NOT NULL,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "Tabela kanban_cards criada com sucesso!\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabela kanban_cards: " . $e->getMessage() . "\n";
}
