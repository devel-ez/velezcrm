<?php
namespace App\Controllers;

use App\Models\Cliente;

class DashboardController extends Controller {
    private $clienteModel;

    public function __construct() {
        parent::__construct();
        $this->clienteModel = new Cliente();
    }

    public function index() {
        $data = [
            'pageTitle' => 'Dashboard',
            'totalClientes' => $this->clienteModel->contarAtivos(),
            'totalServicos' => 0,
            'totalContratos' => 0,
            'totalProjetos' => 0,
            'atividadesRecentes' => [
                [
                    'tipo' => 'info',
                    'icone' => 'info',
                    'cor' => 'info',
                    'titulo' => 'Bem-vindo ao VelezCRM!',
                    'descricao' => 'Sistema iniciado com sucesso.',
                    'data' => date('d/m/Y H:i')
                ]
            ]
        ];

        $this->render('dashboard/index', $data);
    }
}
