<?php
namespace App\Http\Controllers;

use App\Core\BaseController;

/**
 * Classe Controller
 * Estende o BaseController para fornecer funcionalidades específicas da aplicação
 */
class Controller extends BaseController {
    /**
     * Método para renderizar views
     * @param string $view Nome da view
     * @param array $data Dados a serem passados para a view
     */
    protected function view($view, $data = []) {
        // Extrai os dados para variáveis
        extract($data);
        
        // Inclui o cabeçalho
        require_once VIEW_PATH . '/templates/header.php';
        
        // Inclui a view
        require_once VIEW_PATH . "/{$view}.php";
        
        // Inclui o rodapé
        require_once VIEW_PATH . '/templates/footer.php';
    }

    /**
     * Método para retornar JSON
     * @param mixed $data Dados a serem convertidos em JSON
     */
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Método para redirecionar
     * @param string $url URL para redirecionamento
     */
    protected function redirect($url) {
        header("Location: " . APP_URL . "/{$url}");
        exit;
    }

    /**
     * Método para verificar se é uma requisição POST
     * @return bool
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Método para verificar se é uma requisição AJAX
     * @return bool
     */
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
