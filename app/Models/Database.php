<?php
namespace App\Models;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        try {
            // Cria a conexão com o banco de dados usando as constantes definidas
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            // Em caso de erro, exibe uma mensagem amigável
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }
    
    // Implementa o padrão Singleton para garantir apenas uma conexão
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Retorna a conexão ativa
    public function getConnection() {
        return $this->conn;
    }
}
