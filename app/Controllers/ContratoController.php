<?php

namespace App\Controllers;

use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Servico;

class ContratoController extends Controller {
    private $contratoModel;
    private $clienteModel;
    private $servicoModel;

    public function __construct() {
        parent::__construct();
        $this->contratoModel = new Contrato();
        $this->clienteModel = new Cliente();
        $this->servicoModel = new Servico();
    }

    public function index() {
        try {
            $contratos = $this->contratoModel->listarTodos();
            $this->render('contratos/index', ['contratos' => $contratos]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao listar contratos: ' . $e->getMessage());
            $this->render('contratos/index', ['contratos' => []]);
        }
    }

    public function novo() {
        try {
            $clientes = $this->clienteModel->listarTodos();
            $servicos = $this->servicoModel->listarTodos();
            $this->render('contratos/form', [
                'clientes' => $clientes,
                'servicos' => $servicos
            ]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao carregar formulário: ' . $e->getMessage());
            $this->redirect('/');
        }
    }

    public function salvar() {
        try {
            // Validação dos campos obrigatórios
            $camposObrigatorios = ['titulo', 'cliente_id', 'objeto', 'data_validade'];
            foreach ($camposObrigatorios as $campo) {
                if (empty($_POST[$campo])) {
                    throw new \Exception("O campo " . str_replace('_', ' ', $campo) . " é obrigatório.");
                }
            }

            // Validação da data de validade
            $dataValidade = strtotime($_POST['data_validade']);
            if ($dataValidade === false) {
                throw new \Exception("Data de validade inválida.");
            }

            // Prepara os dados para salvar
            $dados = [
                'titulo' => trim($_POST['titulo']),
                'cliente_id' => (int)$_POST['cliente_id'],
                'objeto' => trim($_POST['objeto']),
                'clausulas' => trim($_POST['clausulas'] ?? ''),
                'valor' => floatval(str_replace(',', '.', $_POST['valor'])),
                'data_validade' => $_POST['data_validade'],
                'status' => 'ativo'
            ];

            error_log("Dados do contrato a serem salvos: " . print_r($dados, true));

            // Se for uma edição
            if (!empty($_POST['id'])) {
                $dados['id'] = (int)$_POST['id'];
                $this->contratoModel->atualizar($dados);
                $this->setFlashMessage('success', 'Contrato atualizado com sucesso!');
            } else {
                // Novo contrato
                $id = $this->contratoModel->inserir($dados);
                error_log("Novo contrato inserido com ID: " . $id);
                
                // Gera o número do contrato (ID/ANO)
                $numeroContrato = $id . '/' . date('Y');
                $this->contratoModel->atualizarNumeroContrato($id, $numeroContrato);
                
                $this->setFlashMessage('success', 'Contrato criado com sucesso!');
            }

            // Salva os serviços do contrato
            if (isset($_POST['servicos']) && is_array($_POST['servicos'])) {
                $contratoId = $dados['id'] ?? $id;
                $this->contratoModel->salvarServicos($contratoId, $_POST['servicos']);
            }

            error_log("Contrato salvo com sucesso. Redirecionando para /contratos");
            $this->redirect('/contratos');
        } catch (\Exception $e) {
            error_log("Erro ao salvar contrato: " . $e->getMessage());
            error_log("POST data: " . print_r($_POST, true));
            $this->setFlashMessage('danger', 'Erro ao salvar contrato: ' . $e->getMessage());
            $this->redirect('/contratos/novo');
        }
    }

    public function editar($id) {
        try {
            $contrato = $this->contratoModel->buscarPorId($id);
            if (!$contrato) {
                throw new \Exception('Contrato não encontrado.');
            }

            $clientes = $this->clienteModel->listarTodos();
            $servicos = $this->servicoModel->listarTodos();
            $servicos_selecionados = $this->contratoModel->buscarServicosPorContrato($id);

            $this->render('contratos/form', [
                'contrato' => $contrato,
                'clientes' => $clientes,
                'servicos' => $servicos,
                'servicos_selecionados' => array_column($servicos_selecionados, 'id')
            ]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao carregar contrato: ' . $e->getMessage());
            $this->redirect('/contratos');
        }
    }

    public function excluir($id) {
        try {
            $this->contratoModel->excluir($id);
            $this->setFlashMessage('success', 'Contrato excluído com sucesso!');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao excluir contrato: ' . $e->getMessage());
        }
        $this->redirect('/contratos');
    }
}
