<?php

namespace App\Controllers;

use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Database; // Adicione essa linha para importar a classe Database
use App\Middleware\AuthMiddleware;

class ContratoController extends Controller
{
    private $contratoModel;
    private $clienteModel;
    private $servicoModel;
    private $db; // Adicione essa linha para declarar a propriedade $db

    public function __construct()
    {
        AuthMiddleware::check();
        parent::__construct();
        $this->contratoModel = new Contrato();
        $this->clienteModel = new Cliente();
        $this->servicoModel = new Servico();
        $this->db = Database::getInstance(); // Use o método getInstance para obter a conexão
    }

    public function index()
    {
        try {
            $contratos = $this->contratoModel->listarTodos();
            $this->render('contratos/index', ['contratos' => $contratos]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao listar contratos: ' . $e->getMessage());
            $this->render('contratos/index', ['contratos' => []]);
        }
    }

    public function novo()
    {
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

    public function salvar()
    {
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

            // Processa os valores personalizados
            $valoresPersonalizados = [];
            if (!empty($_POST['servicos']) && !empty($_POST['valor_personalizado'])) {
                foreach ($_POST['servicos'] as $servicoId) {
                    if (isset($_POST['valor_personalizado'][$servicoId])) {
                        $valor = $_POST['valor_personalizado'][$servicoId];
                        $valor = str_replace('.', '', $valor); // Remove pontos de milhar
                        $valor = str_replace(',', '.', $valor); // Converte vírgula em ponto
                        $valoresPersonalizados[$servicoId] = floatval($valor);
                    }
                }
            }

            // Formata os dados
            $dados = [
                'titulo' => trim($_POST['titulo']),
                'cliente_id' => (int)$_POST['cliente_id'],
                'objeto' => trim($_POST['objeto']),
                'clausulas' => trim($_POST['clausulas'] ?? ''),
                'data_validade' => $_POST['data_validade'],
                'status' => 'ativo'
            ];

            // Se for uma edição
            if (!empty($_POST['id'])) {
                $dados['id'] = (int)$_POST['id'];

                // Adiciona os serviços e valores personalizados aos dados
                if (isset($_POST['servicos'])) {
                    $dados['servicos'] = $_POST['servicos'];
                }
                if (isset($_POST['valor_personalizado'])) {
                    $dados['valor_personalizado'] = $valoresPersonalizados;
                }

                $this->contratoModel->atualizar($dados['id'], $dados);
                $this->setFlashMessage('success', 'Contrato atualizado com sucesso!');
            } else {
                // Adiciona os serviços e valores personalizados aos dados
                if (isset($_POST['servicos'])) {
                    $dados['servicos'] = $_POST['servicos'];
                }
                if (isset($_POST['valor_personalizado'])) {
                    $dados['valor_personalizado'] = $valoresPersonalizados;
                }

                // Novo contrato
                $id = $this->contratoModel->criar($dados);
                error_log("Novo contrato inserido com ID: " . $id);

                // Gera o número do contrato (ID/ANO)
                $numeroContrato = $id . '/' . date('Y');
                $this->contratoModel->atualizarNumeroContrato($id, $numeroContrato);

                $this->setFlashMessage('success', 'Contrato criado com sucesso!');
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

    /**
     * Busca os serviços associados a um contrato
     * @param int $contratoId
     * @return array
     */
    public function buscarServicosPorContrato($contratoId)
    {
        try {
            $sql = "SELECT s.*, cs.valor_personalizado 
                FROM servicos s 
                INNER JOIN contratos_servicos cs ON s.id = cs.servico_id 
                WHERE cs.contrato_id = :contrato_id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([':contrato_id' => $contratoId]);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function editar($id)
    {
        try {
            $contrato = $this->contratoModel->buscarPorId($id);
            if (!$contrato) {
                throw new \Exception('Contrato não encontrado.');
            }

            $clientes = $this->clienteModel->listarTodos();
            $servicosDisponiveis = $this->servicoModel->listarTodos();

            // Recupera os serviços associados ao contrato
            $servicosContrato = $this->contratoModel->buscarServicosPorContrato($id);

            // Recupera os valores personalizados do contrato
            $valoresPersonalizados = $this->contratoModel->buscarValoresPersonalizadosPorContrato($id);

            // Passa os dados para a view
            return $this->render('contratos/form', [
                'contrato' => $contrato,
                'clientes' => $clientes,
                'servicos' => $servicosDisponiveis,
                'servicosContrato' => $servicosContrato,
                'valoresPersonalizados' => $valoresPersonalizados
            ]);
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao carregar contrato: ' . $e->getMessage());
            $this->redirect('/contratos');
        }
    }

    public function excluir($id)
    {
        try {
            $this->contratoModel->excluir($id);
            $this->setFlashMessage('success', 'Contrato excluído com sucesso!');
        } catch (\Exception $e) {
            $this->setFlashMessage('danger', 'Erro ao excluir contrato: ' . $e->getMessage());
        }
        $this->redirect('/contratos');
    }
}
