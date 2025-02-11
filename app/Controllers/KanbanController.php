<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Kanban;

class KanbanController extends Controller {
    
    private $clienteModel;
    private $kanbanModel;

    public function __construct() {
        parent::__construct();
        $this->clienteModel = new Cliente();
        $this->kanbanModel = new Kanban();
    }

    // Exibe a página principal do Kanban
    public function index() {
        try {
            $clientes = $this->clienteModel->listarTodos();
            $this->render('kanban/index', [
                'clientes' => $clientes,
                'pageTitle' => 'Kanban Board'
            ]);
        } catch (\Exception $e) {
            $this->setFlashMessage('error', 'Erro ao carregar o Kanban: ' . $e->getMessage());
            $this->redirect('dashboard');
        }
    }

    // Obtém os cards do kanban para um cliente específico
    public function getCards($clienteId) {
        try {
            if (!$clienteId) {
                throw new \Exception('ID do cliente não fornecido');
            }
            $cards = $this->kanbanModel->getCardsByCliente($clienteId);
            $this->json($cards);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()]);
        }
    }

    // Cria um novo card
    public function createCard() {
        try {
            if (!$this->isPost()) {
                throw new \Exception('Método não permitido');
            }

            $clienteId = $_POST['cliente_id'] ?? null;
            $titulo = $_POST['titulo'] ?? null;
            $descricao = $_POST['descricao'] ?? '';
            $status = $_POST['status'] ?? 'backlog';

            if (!$clienteId || !$titulo) {
                throw new \Exception('Dados obrigatórios não fornecidos');
            }

            $data = [
                'cliente_id' => $clienteId,
                'titulo' => $titulo,
                'descricao' => $descricao,
                'status' => $status,
                'data_criacao' => date('Y-m-d H:i:s')
            ];

            if ($this->kanbanModel->createCard($data)) {
                $this->json(['success' => true]);
            } else {
                throw new \Exception('Erro ao criar o card');
            }
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()]);
        }
    }

    // Atualiza a posição/status de um card
    public function updateCardStatus() {
        try {
            if (!$this->isPost()) {
                throw new \Exception('Método não permitido');
            }

            $cardId = $_POST['card_id'] ?? null;
            $status = $_POST['status'] ?? null;
            $posicao = $_POST['posicao'] ?? 0;

            if (!$cardId || !$status) {
                throw new \Exception('Dados obrigatórios não fornecidos');
            }

            $data = [
                'id' => $cardId,
                'status' => $status,
                'posicao' => $posicao
            ];

            if ($this->kanbanModel->updateCardStatus($data)) {
                $this->json(['success' => true]);
            } else {
                throw new \Exception('Erro ao atualizar o card');
            }
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()]);
        }
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
