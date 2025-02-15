<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                header("Location: " . BASE_URL . "/");
                exit;
            } else {
                $this->setFlashMessage('danger', 'Credenciais inválidas.');
                header("Location: " . BASE_URL . "/login");
                exit;
            }
        } else {
            // Renderiza a view de login SEM o layout principal
            require_once __DIR__ . '/../../views/auth/login.php';
        }
    }
}
