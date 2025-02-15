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
            $sql = "INSERT INTO contratos (titulo, cliente_id, objeto, clausulas, data_validade, status, created_at, updated_at) 
                    VALUES (:titulo, :cliente_id, :objeto, :clausulas, :data_validade, :status, NOW(), NOW())";

            // Prepara os dados para inserção
            $params = [
                ':titulo' => $dados['titulo'],
                ':cliente_id' => $dados['cliente_id'],
                ':objeto' => $dados['objeto'],
                ':clausulas' => isset($dados['clausulas']) ? $dados['clausulas'] : '',
                ':data_validade' => $dados['data_validade'],
                ':status' => isset($dados['status']) ? $dados['status'] : 'ativo'
            ];

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            $contratoId = $this->db->lastInsertId();

            // Insere os serviços do contrato com valores personalizados
            if (!empty($dados['servicos'])) {
                foreach ($dados['servicos'] as $servicoId) {
                    $valorPersonalizado = null;
                    if (isset($dados['valor_personalizado']) && isset($dados['valor_personalizado'][$servicoId])) {
                        $valor = $dados['valor_personalizado'][$servicoId];
                        // Remove pontos de milhar e converte vírgula em ponto
                        $valorPersonalizado = str_replace(',', '.', str_replace('.', '', $valor));
                    }

                    $sqlServico = "INSERT INTO contratos_servicos (contrato_id, servico_id, valor_personalizado) 
                                  VALUES (:contrato_id, :servico_id, :valor_personalizado)";
                    $stmt = $this->db->prepare($sqlServico);
                    $stmt->execute([
                        ':contrato_id' => $contratoId,
                        ':servico_id' => $servicoId,
                        ':valor_personalizado' => $valorPersonalizado
                    ]);
                }
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

            // ✅ Log para depuração
            error_log("🔍 Atualizando contrato ID: " . $id);
            error_log("📌 Dados recebidos para atualização: " . print_r($dados, true));

            // ✅ Atualiza os dados do contrato
            $sql = "UPDATE contratos SET 
                    titulo = :titulo,
                    cliente_id = :cliente_id,
                    objeto = :objeto,
                    clausulas = :clausulas,
                    data_validade = :data_validade,
                    updated_at = NOW()
                    WHERE id = :id";

            $params = [
                ':id' => (int) $id,
                ':titulo' => $dados['titulo'] ?? '',
                ':cliente_id' => (int) ($dados['cliente_id'] ?? 0),
                ':objeto' => $dados['objeto'] ?? '',
                ':clausulas' => $dados['clausulas'] ?? '',
                ':data_validade' => $dados['data_validade'] ?? null
            ];

            error_log("📌 Query SQL: " . $sql);
            error_log("📌 Parâmetros: " . json_encode($params));

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            // ✅ Remove os serviços antigos
            $stmt = $this->db->prepare("DELETE FROM contratos_servicos WHERE contrato_id = :id");
            $stmt->execute([':id' => $id]);

            // ✅ Verifica se há novos serviços para adicionar
            if (!empty($dados['servicos'])) {
                $sqlServicos = "INSERT INTO contratos_servicos (contrato_id, servico_id, valor_personalizado) VALUES ";
                $values = [];
                $paramsServicos = [];

                foreach ($dados['servicos'] as $index => $servicoId) {
                    $keyContrato = ":contrato_id_" . $index;
                    $keyServico = ":servico_id_" . $index;
                    $keyValor = ":valor_" . $index;

                    $values[] = "($keyContrato, $keyServico, $keyValor)";
                    $paramsServicos[$keyContrato] = (int) $id;
                    $paramsServicos[$keyServico] = (int) $servicoId;
                    $paramsServicos[$keyValor] = isset($dados['valor_personalizado'][$servicoId])
                        ? str_replace(',', '.', str_replace('.', '', $dados['valor_personalizado'][$servicoId]))
                        : null;
                }

                // ⚠️ A query só é executada se houver serviços
                if (!empty($values)) {
                    $sqlServicos .= implode(', ', $values);

                    error_log("📌 Query de Serviços: " . $sqlServicos);
                    error_log("📌 Parâmetros de Serviços: " . json_encode($paramsServicos));

                    $stmt = $this->db->prepare($sqlServicos);
                    $stmt->execute($paramsServicos);
                }
            }

            // ✅ Confirma a transação
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("❌ Erro ao atualizar contrato: " . $e->getMessage());
            throw $e;
        }
    }




    /**
     * Atualiza o número do contrato
     * @param int $id
     * @param string $numeroContrato
     * @return bool
     */
    public function atualizarNumeroContrato($id, $numeroContrato)
    {
        try {
            $sql = "UPDATE contratos SET numero_contrato = :numero_contrato WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id, ':numero_contrato' => $numeroContrato]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Salva os valores personalizados para um contrato
     * @param int $contratoId
     * @param array $valoresPersonalizados
     * @return void
     */
    public function salvarValoresPersonalizados($contratoId, $valoresPersonalizados)
    {

        foreach ($valoresPersonalizados as $servicoId => $valor) {
            // Converte o valor para o formato correto do banco
            $valor = str_replace('.', '', $valor); // Remove o ponto de milhar
            $valor = str_replace(',', '.', $valor); // Substitui a vírgula por ponto
            $valor = floatval($valor); // Converte para float


            // Modificando a consulta para usar o mesmo parâmetro :valor tanto no INSERT quanto no UPDATE
            $sql = "INSERT INTO contratos_servicos (contrato_id, servico_id, valor_personalizado) 
                   VALUES (:contrato_id, :servico_id, :valor_personalizado) 
                   ON DUPLICATE KEY UPDATE valor_personalizado = VALUES(valor_personalizado)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':contrato_id' => $contratoId,
                ':servico_id' => $servicoId,
                ':valor_personalizado' => $valor
            ]);
        }
    }

    /**
     * Salva os serviços associados a um contrato
     * @param int $contratoId
     * @param array $servicos
     * @return void
     */
    public function salvarServicos($contratoId, $servicos)
    {
        $this->db->beginTransaction();
        try {
            // Remove serviços antigos
            $stmt = $this->db->prepare("DELETE FROM contratos_servicos WHERE contrato_id = :contrato_id");
            $stmt->execute([':contrato_id' => $contratoId]);

            // Insere novos serviços
            foreach ($servicos as $servicoId) {
                $sql = "INSERT INTO contratos_servicos (contrato_id, servico_id) VALUES (:contrato_id, :servico_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':contrato_id' => $contratoId, ':servico_id' => $servicoId]);
            }
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Busca os valores personalizados de um contrato
     * @param int $contratoId
     * @return array
     */
    public function buscarValoresPersonalizadosPorContrato($contratoId)
    {
        try {
            $sql = "SELECT servico_id, valor_personalizado FROM contratos_servicos WHERE contrato_id = :contrato_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':contrato_id' => $contratoId]);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Busca os serviços associados a um contrato
     * @param int $contratoId
     * @return array
     */
    public function buscarServicosPorContrato($contratoId)
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
