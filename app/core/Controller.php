<?php
/**
 * Clase base para todos los controladores
 */

namespace App\Core;

class Controller
{
    /**
     * Renderiza una vista
     */
    protected function render(string $view, array $data = []): void
    {
        // Extraer las variables del array $data para que estén disponibles en la vista
        extract($data);

        // Incluir header
        $headerPath = APP_PATH . 'views/layout/header.php';
        if (file_exists($headerPath)) {
            include $headerPath;
        }

        // Incluir la vista
        $viewPath = APP_PATH . 'views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Vista no encontrada: {$viewPath}";
        }

        // Incluir footer
        $footerPath = APP_PATH . 'views/layout/footer.php';
        if (file_exists($footerPath)) {
            include $footerPath;
        }
    }

    /**
     * Renderiza una vista sin layout
     */
    protected function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = APP_PATH . 'views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Vista no encontrada: {$viewPath}";
        }
    }

    /**
     * Retorna datos en formato JSON
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirige a una URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Obtiene datos del request POST
     */
    protected function post(string $key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Obtiene datos del request GET
     */
    protected function get(string $key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
}

