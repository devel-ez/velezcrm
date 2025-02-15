<?php

namespace App\Models;

use App\Core\Database;

class Kanban
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Obtém os cards de um cliente específico
     */
    public function getCardsByCliente($clienteId)
    {
        try {
            $sql = "SELECT * FROM kanban_cards WHERE cliente_id = :cliente_id ORDER BY posicao ASC";
            $stmt = $this->db->getPdo()->prepare($sql);
            $stmt->execute([':cliente_id' => $clienteId]);

            $cards = $stmt->fetchAll();

            error_log("🔍 Resultado da busca: " . json_encode($cards));

            return $cards;
        } catch (\Exception $e) {
            error_log("❌ Erro na busca de cards: " . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Cria um novo card
     */
    public function createCard($data)
    {
        // Obtém a última posição do status atual
        $sql = "SELECT COALESCE(MAX(posicao), -1) as ultima_posicao 
                FROM kanban_cards 
                WHERE cliente_id = :cliente_id 
                AND status = :status";

        $result = $this->db->select($sql, [
            'cliente_id' => $data['cliente_id'],
            'status' => $data['status']
        ]);

        // Define a nova posição como última + 1
        $data['posicao'] = isset($result[0]['ultima_posicao']) ? $result[0]['ultima_posicao'] + 1 : 0;

        $sql = "INSERT INTO kanban_cards (cliente_id, titulo, descricao, status, posicao, data_criacao) 
                VALUES (:cliente_id, :titulo, :descricao, :status, :posicao, :data_criacao)";

        return $this->db->insert($sql, $data);
    }

    /**
     * Atualiza o status e posição de um card
     */
    public function updateCardStatus($data)
    {
        $sql = "UPDATE kanban_cards 
                SET status = :status, posicao = :posicao 
                WHERE id = :id";
        return $this->db->update($sql, $data);
    }

    /**
     * Atualiza as posições dos cards após uma movimentação
     */
    public function atualizarPosicoesAposMovimentacao($status, $novaPosicao)
    {
        // Atualiza as posições dos cards que vêm depois da nova posição
        $sql = "UPDATE kanban_cards 
                SET posicao = posicao + 1 
                WHERE status = :status 
                AND posicao >= :posicao";

        return $this->db->update($sql, [
            'status' => $status,
            'posicao' => $novaPosicao
        ]);
    }

    /**
     * Edita um card existente
     */
    public function editCard($data)
    {
        try {
            $sql = "UPDATE kanban_cards 
                    SET titulo = :titulo, 
                        descricao = :descricao 
                    WHERE id = :id";

            return $this->db->update($sql, $data);
        } catch (\Exception $e) {
            error_log("Erro ao editar card: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Exclui um card e reordena as posições
     */
    public function deleteCard($cardId)
    {
        try {
            // Primeiro, obtém as informações do card para reordenar depois
            $sql = "SELECT status, posicao FROM kanban_cards WHERE id = :id";
            $card = $this->db->select($sql, ['id' => $cardId]);

            if (!empty($card)) {
                $status = $card[0]['status'];
                $posicao = $card[0]['posicao'];

                // Exclui o card
                $sql = "DELETE FROM kanban_cards WHERE id = :id";
                $deleted = $this->db->delete($sql, ['id' => $cardId]);

                if ($deleted) {
                    // Atualiza as posições dos cards que vêm depois
                    $sql = "UPDATE kanban_cards 
                            SET posicao = posicao - 1 
                            WHERE status = :status 
                            AND posicao > :posicao";

                    $this->db->update($sql, [
                        'status' => $status,
                        'posicao' => $posicao
                    ]);

                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            error_log("Erro ao excluir card: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtém um card específico pelo ID
     */
    public function getCard($cardId)
    {
        try {
            $sql = "SELECT * FROM kanban_cards WHERE id = :id";
            $stmt = $this->db->getPdo()->prepare($sql);
            $stmt->execute([':id' => $cardId]);
            $result = $stmt->fetch();
            return !empty($result) ? $result : null;
        } catch (\Exception $e) {
            error_log("Erro ao obter card: " . $e->getMessage());
            return null;
        }
    }
}
