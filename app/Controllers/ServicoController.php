<?php

namespace App\Controllers;

use App\Models\Servico;
use App\Middleware\AuthMiddleware;

class ServicoController extends Controller {
    private $servicoModel;

    public function __construct() {
        AuthMiddleware::check();
        parent::__construct();
        $this->servicoModel = new Servico();
    }

    public function index() {
        try {
            $servicos = $this->servicoModel->listarTodos();
            $this->render('servicos/index', ['servicos' => $servicos]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao listar serviços: ' . $e->getMessage());
            $this->redirect('servicos');
        }
    }

    public function novo() {
        $this->render('servicos/form');
    }

    public function salvar() {
        try {
            if (empty($_POST['nome']) || empty($_POST['valor'])) {
                throw new \Exception('Nome e valor são campos obrigatórios.');
            }

            $dados = [
                'nome' => trim($_POST['nome']),
                'descricao' => trim($_POST['descricao']),
                'valor' => (float)$_POST['valor']
            ];

            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $sucesso = $this->servicoModel->atualizar($_POST['id'], $dados);
                $mensagem = 'Serviço atualizado com sucesso!';
            } else {
                $sucesso = $this->servicoModel->criar($dados);
                $mensagem = 'Serviço cadastrado com sucesso!';
            }

            if ($sucesso) {
                $this->setFlashMessage('success', $mensagem);
                $this->redirect('servicos');
            } else {
                throw new \Exception('Erro ao salvar o serviço. Por favor, tente novamente.');
            }
        } catch (\Exception $e) {
            error_log("Erro ao salvar serviço: " . $e->getMessage());
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('servicos/novo');
        }
    }

    public function editar($id) {
        try {
            $servico = $this->servicoModel->buscarPorId($id);
            if (!$servico) {
                throw new \Exception('Serviço não encontrado.');
            }
            $this->render('servicos/form', ['servico' => $servico]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('servicos');
        }
    }

    public function excluir($id) {
        try {
            if ($this->servicoModel->excluir($id)) {
                $this->setFlashMessage('success', 'Serviço excluído com sucesso!');
            } else {
                throw new \Exception('Erro ao excluir o serviço.');
            }
            $this->redirect('servicos');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('servicos');
        }
    }
}
