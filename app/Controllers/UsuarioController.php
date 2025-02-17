<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Middleware\AuthMiddleware;

class UsuarioController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        AuthMiddleware::check();
        parent::__construct();
        $this->usuarioModel = new Usuario(); // Agora funciona com a conexão Singleton

    }

    // Exibe a lista de usuários
    public function index()
    {
        $usuarios = $this->usuarioModel->listarTodos();
        $this->render('configuracoes/index', ['usuarios' => $usuarios]);
    }

    // Exibe o formulário para adicionar um novo usuário
    public function novo()
    {
        $this->render('configuracoes/form');
    }

    // Salvar novo usuário
    public function salvar()
    {
        try {
            $nome = $_POST['nome'] ?? null;
            $email = $_POST['email'] ?? null;
            $senha = $_POST['senha'] ?? null;
            $tipo = $_POST['tipo'] ?? 'usuario';

            if (!$nome || !$email || !$senha) {
                throw new \Exception('Todos os campos são obrigatórios!');
            }

            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

            $dados = [
                'nome' => $nome,
                'email' => $email,
                'senha' => $senhaHash,
                'tipo' => $tipo,
                'status' => 'ativo'
            ];

            $this->usuarioModel->criar($dados);
            $this->setFlashMessage('success', 'Usuário cadastrado com sucesso!');
            $this->redirect('configuracoes');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('configuracoes/novo');
        }
    }

    // Editar usuário
    public function editar($id)
    {
        $usuario = $this->usuarioModel->buscarPorId($id);
        $this->render('configuracoes/form', ['usuario' => $usuario]);
    }

    // Atualizar usuário
    public function atualizar()
    {
        try {
            $id = $_POST['id'] ?? null;
            $nome = $_POST['nome'] ?? null;
            $email = $_POST['email'] ?? null;
            $tipo = $_POST['tipo'] ?? 'usuario';

            if (!$id || !$nome || !$email) {
                throw new \Exception('Todos os campos são obrigatórios!');
            }

            $dados = [
                'id' => $id,
                'nome' => $nome,
                'email' => $email,
                'tipo' => $tipo
            ];

            $this->usuarioModel->atualizar($dados);
            $this->setFlashMessage('success', 'Usuário atualizado com sucesso!');
            $this->redirect('configuracoes');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('configuracoes/editar/' . $_POST['id']);
        }
    }

    // Excluir usuário
    public function excluir()
    {
        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido!');
            }

            $this->usuarioModel->excluir($id);
            $this->setFlashMessage('success', 'Usuário excluído com sucesso!');
            $this->redirect('configuracoes');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('configuracoes');
        }
    }

    // Alterar senha do usuário
    public function mudarSenha()
    {
        try {
            $id = $_POST['id'] ?? null;
            $novaSenha = $_POST['nova_senha'] ?? null;

            if (!$id || !$novaSenha) {
                throw new \Exception('Todos os campos são obrigatórios!');
            }

            $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);
            $this->usuarioModel->mudarSenha($id, $senhaHash);
            $this->setFlashMessage('success', 'Senha alterada com sucesso!');
            $this->redirect('configuracoes');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('configuracoes');
        }
    }
}
