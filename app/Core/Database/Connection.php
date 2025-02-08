<?php
namespace App\Core\Database;

use PDO;
use PDOException;

/**
 * Classe Connection - Gerencia a conexão com o banco de dados
 * Implementa o padrão Singleton para garantir uma única instância da conexão
 */
class Connection {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ]
            );
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Retorna a instância única da classe Connection
     * @return Connection
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retorna a conexão PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Previne que a classe seja clonada
     */
    private function __clone() {}

    /**
     * Previne que a classe seja deserializada
     */
    private function __wakeup() {}
}
