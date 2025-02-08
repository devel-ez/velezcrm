<?php
namespace App\Core;

use App\Config\Database;
use PDO;

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Busca todos os registros
     */
    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Busca um registro pelo ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Cria um novo registro
     */
    public function create($data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        return $stmt->execute();
    }

    /**
     * Atualiza um registro
     */
    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }
        $fields = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $data['id'] = $id;
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        
        return $stmt->execute();
    }

    /**
     * Remove um registro
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
