<?php
namespace App\Models;

use App\Core\BaseModel;

/**
 * Model para gerenciar usuários do sistema
 */
class User extends BaseModel {
    protected $table = 'users';

    /**
     * Busca um usuário pelo email
     * @param string $email
     * @return object|false
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}
