<?php
namespace App\Controllers;

use App\Models\Cliente;
use App\Middleware\AuthMiddleware;

class ClienteController extends Controller {
    private $clienteModel;

    public function __construct() {
        AuthMiddleware::check();
        parent::__construct();
        $this->clienteModel = new Cliente();
    }

    public function index() {
        try {
            $clientes = $this->clienteModel->listarTodos();
            $this->render('clientes/index', ['clientes' => $clientes]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao listar clientes: ' . $e->getMessage());
            $this->redirect('clientes');
        }
    }

    public function novo() {
        $this->render('clientes/form');
    }

    public function salvar() {
        try {
            // Validação dos campos obrigatórios
            if (empty($_POST['nome']) || empty($_POST['telefone'])) {
                throw new \Exception('Nome e telefone são campos obrigatórios.');
            }

            // Limpa e formata os dados
            $dados = [
                'nome' => trim($_POST['nome']),
                'telefone' => preg_replace('/[^0-9]/', '', $_POST['telefone']),
                'empresa' => isset($_POST['empresa']) ? trim($_POST['empresa']) : null,
                'cnpj' => isset($_POST['cnpj']) ? preg_replace('/[^0-9]/', '', $_POST['cnpj']) : null,
                'login_hospedagem' => isset($_POST['login_hospedagem']) ? trim($_POST['login_hospedagem']) : null,
                'senha_hospedagem' => isset($_POST['senha_hospedagem']) ? trim($_POST['senha_hospedagem']) : null,
                'login_wp' => isset($_POST['login_wp']) ? trim($_POST['login_wp']) : null,
                'senha_wp' => isset($_POST['senha_wp']) ? trim($_POST['senha_wp']) : null,
                'observacoes' => isset($_POST['observacoes']) ? trim($_POST['observacoes']) : null,
                'status' => isset($_POST['status']) ? trim($_POST['status']) : 'ativo'
            ];

            // Se tem CNPJ, valida se já existe
            if (!empty($dados['cnpj'])) {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                if ($this->clienteModel->existeCNPJ($dados['cnpj'], $id)) {
                    throw new \Exception('Já existe um cliente cadastrado com este CNPJ.');
                }
            }

            // Atualiza ou cria novo cliente
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $sucesso = $this->clienteModel->atualizar($_POST['id'], $dados);
                $mensagem = 'Cliente atualizado com sucesso!';
            } else {
                $sucesso = $this->clienteModel->criar($dados);
                $mensagem = 'Cliente cadastrado com sucesso!';
            }

            if ($sucesso) {
                $this->setFlashMessage('success', $mensagem);
                $this->redirect('clientes');
            } else {
                throw new \Exception('Erro ao salvar o cliente. Por favor, tente novamente.');
            }
        } catch (\Exception $e) {
            error_log("Erro ao salvar cliente: " . $e->getMessage());
            $this->setFlashMessage('danger', $e->getMessage());
            
            // Se for edição, volta para o formulário de edição
            if (isset($_POST['id'])) {
                $this->redirect('clientes/editar/' . $_POST['id']);
            } else {
                // Se for novo, volta para o formulário de novo
                $this->redirect('clientes/novo');
            }
        }
    }

    public function editar($id) {
        try {
            $cliente = $this->clienteModel->buscarPorId($id);
            if (!$cliente) {
                throw new \Exception('Cliente não encontrado.');
            }
            $this->render('clientes/form', ['cliente' => $cliente]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
            $this->redirect('clientes');
        }
    }

    public function excluir($id) {
        try {
            if ($this->clienteModel->excluir($id)) {
                $this->setFlashMessage('success', 'Cliente excluído com sucesso!');
            } else {
                throw new \Exception('Erro ao excluir o cliente.');
            }
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', $e->getMessage());
        }
        $this->redirect('clientes');
    }

    public function visualizar($id) {
        $cliente = $this->clienteModel->buscarPorId($id);
        
        if (!$cliente) {
            $this->redirect('/clientes');
            return;
        }
        
        $data = [
            'pageTitle' => 'Detalhes do Cliente',
            'cliente' => $cliente
        ];
        
        $this->render('clientes/visualizar', $data);
    }
}
