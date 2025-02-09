<?php

namespace App\Models;

use App\Core\Database;
use PDOException;

class Servico {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Lista todos os serviços cadastrados
     * @return array
     */
    public function listarTodos() {
        try {
            $sql = "SELECT * FROM servicos ORDER BY nome ASC";
            return $this->db->query($sql)->fetchAll();
        } catch (\Exception $e) {
            error_log("Erro ao listar serviços: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cria um novo serviço
     * @param array $dados Dados do serviço
     * @return bool
     */
    public function criar($dados) {
        try {
            $sql = "INSERT INTO servicos (nome, descricao, valor) VALUES (:nome, :descricao, :valor)";
            $params = [
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':valor' => $dados['valor']
            ];
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("Erro ao criar serviço: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza um serviço
     * @param int $id ID do serviço
     * @param array $dados Dados do serviço
     * @return bool
     */
    public function atualizar($id, $dados) {
        try {
            $sql = "UPDATE servicos SET nome = :nome, descricao = :descricao, valor = :valor WHERE id = :id";
            $params = [
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':valor' => $dados['valor'],
                ':id' => $id
            ];
            return $this->db->query($sql, $params);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar serviço: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Exclui um serviço
     * @param int $id ID do serviço
     * @return bool
     */
    public function excluir($id) {
        try {
            $sql = "DELETE FROM servicos WHERE id = :id";
            return $this->db->query($sql, [':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir serviço: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Busca um serviço pelo ID
     * @param int $id ID do serviço
     * @return array|false
     */
    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM servicos WHERE id = :id";
            $params = [':id' => $id];
            return $this->db->query($sql, $params)->fetch();
        } catch (\Exception $e) {
            error_log("Erro ao buscar serviço por ID: " . $e->getMessage());
            throw $e;
        }
    }
}
