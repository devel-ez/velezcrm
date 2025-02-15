<?php

namespace App\Middleware;

// Garante que a configuração é carregada
require_once __DIR__ . '/../../config/config.php';

class AuthMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }
}
