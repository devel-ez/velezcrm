<?php

namespace App\Models;

use App\Core\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        return $this->db->select($sql, [':email' => $email])[0] ?? null;
    }
}
