<?php
namespace App\Http\Controllers;

use App\Models\User;

/**
 * Controller de Autenticação
 * Gerencia login, logout e outras funcionalidades relacionadas à autenticação
 */
class AuthController extends Controller {
    public function index() {
        // Se já estiver logado, redireciona para o dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('');
        }
        
        // Renderiza a página de login usando o layout de autenticação
        $this->view('auth/login', ['pageTitle' => 'Login'], 'auth');
    }
    
    /**
     * Realiza o login do usuário
     */
    public function login() {
        if ($this->isPost()) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            // Implementar a verificação do usuário aqui
            if ($email === 'admin@velezcrm.com' && $password === 'admin123') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user_name'] = 'Administrador';
                $_SESSION['user_role'] = 'admin';
                
                $this->redirect('');
            } else {
                $_SESSION['error'] = 'Email ou senha inválidos';
                $this->redirect('auth');
            }
        }
    }
    
    /**
     * Realiza o logout do usuário
     */
    public function logout() {
        session_destroy();
        $this->redirect('auth');
    }
}
