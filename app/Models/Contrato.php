<?php

namespace App\Models;

use App\Database\Database;

class Contrato {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function listarTodos() {
        try {
            $sql = "SELECT c.*, cl.nome as cliente_nome 
                    FROM contratos c 
                    LEFT JOIN clientes cl ON c.cliente_id = cl.id 
                    ORDER BY c.created_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            error_log("Erro ao listar contratos: " . $e->getMessage());
            throw $e;
        }
    }

    public function inserir($dados) {
        try {
            $sql = "INSERT INTO contratos (titulo, cliente_id, objeto, clausulas, valor, data_validade, status, created_at, updated_at) 
                    VALUES (:titulo, :cliente_id, :objeto, :clausulas, :valor, :data_validade, :status, NOW(), NOW())";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':titulo' => $dados['titulo'],
                ':cliente_id' => $dados['cliente_id'],
                ':objeto' => $dados['objeto'],
                ':clausulas' => $dados['clausulas'],
                ':valor' => $dados['valor'],
                ':data_validade' => $dados['data_validade'],
                ':status' => $dados['status']
            ]);

            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            error_log("Erro ao inserir contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function atualizarNumeroContrato($id, $numeroContrato) {
        try {
            $sql = "UPDATE contratos SET numero_contrato = :numero_contrato WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':numero_contrato' => $numeroContrato,
                ':id' => $id
            ]);
        } catch (\Exception $e) {
            error_log("Erro ao atualizar número do contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function atualizar($dados) {
        try {
            $sql = "UPDATE contratos 
                    SET titulo = :titulo,
                        cliente_id = :cliente_id,
                        objeto = :objeto,
                        clausulas = :clausulas,
                        valor = :valor,
                        data_validade = :data_validade,
                        updated_at = NOW()
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $dados['id'],
                ':titulo' => $dados['titulo'],
                ':cliente_id' => $dados['cliente_id'],
                ':objeto' => $dados['objeto'],
                ':clausulas' => $dados['clausulas'],
                ':valor' => $dados['valor'],
                ':data_validade' => $dados['data_validade']
            ]);
        } catch (\Exception $e) {
            error_log("Erro ao atualizar contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT c.*, cl.nome as cliente_nome 
                    FROM contratos c 
                    LEFT JOIN clientes cl ON c.cliente_id = cl.id 
                    WHERE c.id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (\Exception $e) {
            error_log("Erro ao buscar contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function excluir($id) {
        try {
            // Primeiro exclui os serviços associados
            $sql = "DELETE FROM contratos_servicos WHERE contrato_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);

            // Depois exclui o contrato
            $sql = "DELETE FROM contratos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
        } catch (\Exception $e) {
            error_log("Erro ao excluir contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function salvarServicos($contratoId, $servicos) {
        try {
            // Primeiro remove todos os serviços existentes
            $sql = "DELETE FROM contratos_servicos WHERE contrato_id = :contrato_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':contrato_id' => $contratoId]);

            // Depois insere os novos serviços
            if (!empty($servicos)) {
                $sql = "INSERT INTO contratos_servicos (contrato_id, servico_id) VALUES (:contrato_id, :servico_id)";
                $stmt = $this->db->prepare($sql);

                foreach ($servicos as $servicoId) {
                    $stmt->execute([
                        ':contrato_id' => $contratoId,
                        ':servico_id' => $servicoId
                    ]);
                }
            }
        } catch (\Exception $e) {
            error_log("Erro ao salvar serviços do contrato: " . $e->getMessage());
            throw $e;
        }
    }

    public function buscarServicosPorContrato($contratoId) {
        try {
            $sql = "SELECT s.* 
                    FROM servicos s 
                    INNER JOIN contratos_servicos cs ON s.id = cs.servico_id 
                    WHERE cs.contrato_id = :contrato_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':contrato_id' => $contratoId]);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            error_log("Erro ao buscar serviços do contrato: " . $e->getMessage());
            throw $e;
        }
    }
}
