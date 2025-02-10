<?php

namespace App\Models;

use App\Database\Database;

class Contrato
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Lista todos os contratos
     * @return array
     */
    public function listarTodos()
    {
        try {
            $sql = "SELECT c.*, cl.nome as cliente_nome 
                    FROM contratos c 
                    INNER JOIN clientes cl ON c.cliente_id = cl.id 
                    ORDER BY c.created_at DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Busca um contrato pelo ID
     * @param int $id
     * @return array|false
     */
    public function buscarPorId($id)
    {
        try {
            $sql = "SELECT c.*, cl.nome as cliente_nome 
                    FROM contratos c 
                    INNER JOIN clientes cl ON c.cliente_id = cl.id 
                    WHERE c.id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Cria um novo contrato
     * @param array $dados
     * @return int ID do contrato criado
     */
    public function criar($dados)
    {
        try {
            $this->db->beginTransaction();

            // Insere o contrato
            $sql = "INSERT INTO contratos (titulo, cliente_id, clausulas, created_at, updated_at) 
                    VALUES (:titulo, :cliente_id, :clausulas, NOW(), NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':titulo' => $dados['titulo'],
                ':cliente_id' => $dados['cliente_id'],
                ':clausulas' => $dados['clausulas']
            ]);

            $contratoId = $this->db->lastInsertId();

            // Insere os serviços do contrato com valores personalizados
            if (!empty($dados['servicos'])) {
                $sqlServicos = "INSERT INTO contratos_servicos (contrato_id, servico_id, valor_personalizado) VALUES ";
                $values = [];
                $params = [];

                foreach ($dados['servicos'] as $servicoId) {
                    $key = ":servico_id_" . $servicoId;
                    $keyValor = ":valor_" . $servicoId;
                    $values[] = "(:contrato_id, $key, $keyValor)";
                    $params[':contrato_id'] = $contratoId;
                    $params[$key] = $servicoId;
                    $params[$keyValor] = isset($dados['valor_personalizado'][$servicoId]) ? 
                        $dados['valor_personalizado'][$servicoId] : null;
                }

                $sqlServicos .= implode(', ', $values);
                $stmt = $this->db->prepare($sqlServicos);
                $stmt->execute($params);
            }

            $this->db->commit();
            return $contratoId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Atualiza um contrato existente
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados)
    {
        try {
            $this->db->beginTransaction();

            // Atualiza o contrato
            $sql = "UPDATE contratos SET 
                    titulo = :titulo,
                    cliente_id = :cliente_id,
                    clausulas = :clausulas,
                    updated_at = NOW()
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':titulo' => $dados['titulo'],
                ':cliente_id' => $dados['cliente_id'],
                ':clausulas' => $dados['clausulas']
            ]);

            // Remove os serviços antigos
            $stmt = $this->db->prepare("DELETE FROM contratos_servicos WHERE contrato_id = :id");
            $stmt->execute([':id' => $id]);

            // Insere os novos serviços com valores personalizados
            if (!empty($dados['servicos'])) {
                $sqlServicos = "INSERT INTO contratos_servicos (contrato_id, servico_id, valor_personalizado) VALUES ";
                $values = [];
                $params = [];

                foreach ($dados['servicos'] as $servicoId) {
                    $key = ":servico_id_" . $servicoId;
                    $keyValor = ":valor_" . $servicoId;
                    $values[] = "(:contrato_id, $key, $keyValor)";
                    $params[':contrato_id'] = $id;
                    $params[$key] = $servicoId;
                    $params[$keyValor] = isset($dados['valor_personalizado'][$servicoId]) ? 
                        $dados['valor_personalizado'][$servicoId] : null;
                }

                $sqlServicos .= implode(', ', $values);
                $stmt = $this->db->prepare($sqlServicos);
                $stmt->execute($params);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Exclui um contrato
     * @param int $id
     * @return bool
     */
    public function excluir($id)
    {
        try {
            $this->db->beginTransaction();

            // Remove os serviços
            $stmt = $this->db->prepare("DELETE FROM contratos_servicos WHERE contrato_id = :id");
            $stmt->execute([':id' => $id]);

            // Remove o contrato
            $stmt = $this->db->prepare("DELETE FROM contratos WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Busca os serviços de um contrato
     * @param int $contratoId
     * @return array
     */
    public function buscarServicos($contratoId)
    {
        try {
            $sql = "SELECT s.*, cs.valor_personalizado 
                    FROM servicos s 
                    INNER JOIN contratos_servicos cs ON s.id = cs.servico_id 
                    WHERE cs.contrato_id = :contrato_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':contrato_id' => $contratoId]);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
