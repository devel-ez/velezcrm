<?php

namespace App\Models;

use App\Core\Database;

class Kanban {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Obtém todos os cards de um cliente específico
    public function getCardsByCliente($clienteId) {
        $sql = "SELECT * FROM kanban_cards WHERE cliente_id = :cliente_id ORDER BY posicao ASC";
        return $this->db->select($sql, ['cliente_id' => $clienteId]);
    }

    // Cria um novo card
    public function createCard($data) {
        $sql = "INSERT INTO kanban_cards (cliente_id, titulo, descricao, status, data_criacao) 
                VALUES (:cliente_id, :titulo, :descricao, :status, :data_criacao)";
        return $this->db->insert($sql, $data);
    }

    // Atualiza o status e posição de um card
    public function updateCardStatus($data) {
        $sql = "UPDATE kanban_cards SET status = :status, posicao = :posicao WHERE id = :id";
        return $this->db->update($sql, $data);
    }
}
