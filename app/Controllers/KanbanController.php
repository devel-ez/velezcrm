<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Kanban;
use App\Middleware\AuthMiddleware;

class KanbanController extends Controller {
    
    private $clienteModel;
    private $kanbanModel;

    public function __construct() {
        AuthMiddleware::check();
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
            
            // Retorna JSON com cabeçalho correto
            header('Content-Type: application/json');
            echo json_encode($cards);
            exit;
        } catch (\Exception $e) {
            // Retorna erro em JSON
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
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

            $cardId = $this->kanbanModel->createCard($data);
            
            // Retorna JSON com cabeçalho correto
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'card_id' => $cardId
            ]);
            exit;
        } catch (\Exception $e) {
            // Retorna erro em JSON
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false, 
                'error' => $e->getMessage()
            ]);
            exit;
        }
    }

    // Atualiza o status e a posição de um card
    public function updateCardStatus() {
        try {
            if (!$this->isPost()) {
                throw new \Exception('Método não permitido');
            }

            $cardId = $_POST['card_id'] ?? null;
            $newStatus = $_POST['new_status'] ?? null;
            $position = $_POST['position'] ?? 0;

            if (!$cardId || !$newStatus) {
                throw new \Exception('Dados obrigatórios não fornecidos');
            }

            // Primeiro, atualiza todas as posições dos cards que vêm depois
            $this->kanbanModel->atualizarPosicoesAposMovimentacao($newStatus, $position);

            // Depois atualiza o card movido
            $data = [
                'id' => $cardId,
                'status' => $newStatus,
                'posicao' => $position
            ];

            $success = $this->kanbanModel->updateCardStatus($data);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Erro ao atualizar o card');
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Edita um card existente
     */
    public function editCard() {
        try {
            if (!$this->isPost()) {
                throw new \Exception('Método não permitido');
            }

            $cardId = $_POST['card_id'] ?? null;
            $titulo = $_POST['titulo'] ?? null;
            $descricao = $_POST['descricao'] ?? '';

            if (!$cardId || !$titulo) {
                throw new \Exception('Dados obrigatórios não fornecidos');
            }

            $data = [
                'id' => $cardId,
                'titulo' => $titulo,
                'descricao' => $descricao
            ];

            $success = $this->kanbanModel->editCard($data);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Erro ao editar o card');
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Exclui um card do Kanban
     */
    public function deleteCard() {
        try {
            if (!$this->isPost()) {
                throw new \Exception('Método não permitido');
            }

            $cardId = $_POST['card_id'] ?? null;

            if (!$cardId) {
                throw new \Exception('ID do card não fornecido');
            }

            $success = $this->kanbanModel->deleteCard($cardId);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Erro ao excluir o card');
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Obtém um card específico
     */
    public function getCard($cardId) {
        try {
            if (!$cardId) {
                throw new \Exception('ID do card não fornecido');
            }

            $card = $this->kanbanModel->getCard($cardId);
            
            header('Content-Type: application/json');
            if ($card) {
                echo json_encode($card);
            } else {
                throw new \Exception('Card não encontrado');
            }
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
