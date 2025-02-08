<?php
namespace App\Http\Controllers;

/**
 * Controller da Página Inicial
 * Gerencia o dashboard e outras funcionalidades da página inicial
 */
class HomeController extends Controller {
    /**
     * Exibe o dashboard principal
     */
    public function index() {
        // Dados para o dashboard
        $data = [
            'pageTitle' => 'Painel',
            'totalClients' => 0,
            'totalServices' => 0,
            'totalContracts' => 0,
            'totalTasks' => 0
        ];
        
        $this->view('home/index', $data);
    }
}
