<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
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
