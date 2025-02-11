<?php

namespace App\Core;

/**
 * Classe base para todos os controllers
 */
class Controller {
    /**
     * Carrega uma view
     * @param string $view Nome da view a ser carregada
     * @param array $data Dados a serem passados para a view
     * @return void
     */
    protected function view($view, $data = []) {
        // Verifica se o arquivo da view existe
        $viewFile = APPROOT . '/Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('View não encontrada');
        }
    }

    /**
     * Redireciona para uma URL específica
     * @param string $url URL para redirecionamento
     * @return void
     */
    protected function redirect($url) {
        header('Location: ' . URLROOT . $url);
        exit;
    }

    /**
     * Retorna uma resposta JSON
     * @param mixed $data Dados a serem convertidos para JSON
     * @return void
     */
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Verifica se a requisição é POST
     * @return bool
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Verifica se a requisição é GET
     * @return bool
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Obtém dados do POST
     * @param string $key Chave do dado
     * @param mixed $default Valor padrão caso a chave não exista
     * @return mixed
     */
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    /**
     * Obtém dados do GET
     * @param string $key Chave do dado
     * @param mixed $default Valor padrão caso a chave não exista
     * @return mixed
     */
    protected function getGet($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}
