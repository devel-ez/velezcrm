<?php

namespace App\Models;

use App\Models\Database;
use PDO;

class Usuario
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function listarTodos()
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios ORDER BY nome ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados)
    {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$dados['nome'], $dados['email'], $dados['senha'], $dados['tipo'], $dados['status']]);
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, tipo = ? WHERE id = ?");
        return $stmt->execute([$dados['nome'], $dados['email'], $dados['tipo'], $id]);
    }

    public function excluir($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function mudarSenha($id, $senha)
    {
        $stmt = $this->conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        return $stmt->execute([$senha, $id]);
    }

    public function emailExiste($email)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}
