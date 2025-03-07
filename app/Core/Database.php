<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $pdo;
    private $inTransaction = false;

    /**
     * Construtor que inicializa a conexão com o banco de dados
     */
    public function __construct() {
        try {
            // Configurações do banco de dados
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            
            // Cria a conexão
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
            throw new \Exception("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
        }
    }

    /**
     * Inicia uma transação
     */
    public function beginTransaction() {
        if (!$this->inTransaction) {
            $this->pdo->beginTransaction();
            $this->inTransaction = true;
        }
    }

    /**
     * Confirma uma transação
     */
    public function commit() {
        if ($this->inTransaction) {
            $this->pdo->commit();
            $this->inTransaction = false;
        }
    }

    /**
     * Reverte uma transação
     */
    public function rollback() {
        if ($this->inTransaction) {
            $this->pdo->rollBack();
            $this->inTransaction = false;
        }
    }

    /**
     * Prepara e executa uma query SQL
     * @param string $sql Query SQL
     * @param array $params Parâmetros para bind
     * @return \PDOStatement
     */
    public function query($sql, $params = []) {
        try {
            error_log("Executando query: " . $sql);
            error_log("Parâmetros: " . json_encode($params));
            
            $stmt = $this->pdo->prepare($sql);
            
            // Bind each parameter
            foreach ($params as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $type);
            }
            
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erro na execução da query: " . $e->getMessage());
            error_log("SQL: " . $sql);
            error_log("Parâmetros: " . json_encode($params));
            throw $e;
        }
    }

    /**
     * Retorna o ID do último registro inserido
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * Executa uma consulta SELECT e retorna os resultados
     * @param string $sql Query SQL
     * @param array $params Parâmetros para bind
     * @return array Resultados da consulta
     */
    public function select($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Executa uma inserção no banco de dados
     * @param string $sql Query SQL de inserção
     * @param array $params Parâmetros para bind
     * @return int ID do registro inserido ou false em caso de erro
     */
    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->lastInsertId();
    }

    /**
     * Executa uma atualização no banco de dados
     * @param string $sql Query SQL de atualização
     * @param array $params Parâmetros para bind
     * @return int Número de linhas afetadas
     */
    public function update($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Executa uma query DELETE
     */
    public function delete($sql, $params = []) {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Erro ao executar DELETE: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna a conexão PDO
     * @return PDO
     */
    public function getPdo() {
        return $this->pdo;
    }
}
