<?php
namespace App\Controllers;

// Importando a classe Exception
use Exception;

class Controller {
    /**
     * Construtor da classe base
     * Inicializa recursos comuns a todos os controllers
     */
    public function __construct() {
        // Garante que a sessão está iniciada
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    protected function render($view, $data = []) {
        // Adiciona a mensagem flash aos dados da view
        $flash = $this->getFlashMessage();
        if ($flash) {
            $data['flash'] = $flash;
        }

        // Extrai as variáveis do array para uso na view
        extract($data);
        
        // Inicia o buffer de saída
        ob_start();
        
        // Inclui a view específica
        $viewFile = __DIR__ . '/../../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            throw new Exception("View {$view} não encontrada");
        }
        
        // Obtém o conteúdo do buffer
        $content = ob_get_clean();
        
        // Renderiza o layout com o conteúdo
        require __DIR__ . '/../../views/layouts/main.php';
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit();
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Define uma mensagem flash para ser exibida na próxima requisição
     * @param string $tipo - Tipo da mensagem (success, error, warning, info)
     * @param string $mensagem - Conteúdo da mensagem
     */
    protected function setFlashMessage($tipo, $mensagem) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash'] = [
            'tipo' => $tipo,
            'mensagem' => $mensagem
        ];
    }

    /**
     * Retorna a mensagem flash atual e a remove da sessão
     * @return array|null
     */
    protected function getFlashMessage() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}
