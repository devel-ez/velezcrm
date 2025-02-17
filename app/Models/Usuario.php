<?php

namespace App\Models;

use App\Models\Database;
use PDO;

class Usuario
{
    private $conn;

    public function __construct()
    {
        // Obtém a conexão ativa do banco de dados
        $this->conn = Database::getInstance()->getConnection();
    }

    public function listarTodos()
    {
        $stmt = $this->conn->query("SELECT * FROM usuarios ORDER BY nome ASC");
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

    public function atualizar($dados)
    {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nome = ?, email = ?, tipo = ? WHERE id = ?");
        return $stmt->execute([$dados['nome'], $dados['email'], $dados['tipo'], $dados['id']]);
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
}
