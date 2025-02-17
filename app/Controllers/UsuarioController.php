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
        $this->usuarioModel = new Usuario();
    }

    // Exibir lista de usuários
    public function index()
    {
        try {
            $usuarios = $this->usuarioModel->listarTodos();
            $this->render('configuracoes/index', ['usuarios' => $usuarios]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao listar usuários: ' . $e->getMessage());
            $this->redirect('configuracoes');
        }
    }

    // Exibir formulário para adicionar novo usuário
    public function novo()
    {
        $this->render('configuracoes/form');
    }

    // Salvar novo usuário ou atualizar existente
    public function salvar()
    {
        try {
            if (empty($_POST['nome']) || empty($_POST['email'])) {
                throw new \Exception('Nome e e-mail são obrigatórios.');
            }

            $dados = [
                'nome' => trim($_POST['nome']),
                'email' => trim($_POST['email']),
                'tipo' => $_POST['tipo'] ?? 'usuario',
                'status' => $_POST['status'] ?? 'ativo'
            ];

            if (!empty($_POST['id'])) {
                $this->usuarioModel->atualizar($_POST['id'], $dados);
                $this->setFlashMessage('success', 'Usuário atualizado com sucesso!');
            } else {
                $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $this->usuarioModel->criar($dados);
                $this->setFlashMessage('success', 'Usuário cadastrado com sucesso!');
            }

            header("Location: /velezcrm/configuracoes");
            exit;
        } catch (\Exception $e) {
            http_response_code(400);
            echo "Erro: " . $e->getMessage();
        }
    }


    // Editar usuário
    public function editar($id)
    {
        try {
            $usuario = $this->usuarioModel->buscarPorId($id);
            if (!$usuario) {
                throw new \Exception('Usuário não encontrado.');
            }
            $this->render('configuracoes/form', ['usuario' => $usuario]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao editar usuário: ' . $e->getMessage());
            $this->redirect('configuracoes');
        }
    }

    // Excluir usuário
    public function excluir()
    {
        try {
            if (empty($_POST['id'])) {
                throw new \Exception('ID do usuário não fornecido.');
            }

            $this->usuarioModel->excluir($_POST['id']);
            $this->setFlashMessage('success', 'Usuário excluído com sucesso!');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao excluir usuário: ' . $e->getMessage());
        }

        $this->redirect('configuracoes');
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
