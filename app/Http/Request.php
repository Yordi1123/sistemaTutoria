<?php
/**
 * Clase Request para manejar peticiones HTTP
 */

namespace App\Http;

class Request
{
    private $data;
    private $method;
    private $uri;
    private $headers;
    private $params;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $this->getUri();
        $this->headers = $this->getHeaders();
        $this->data = $this->collectData();
        $this->params = [];
    }

    /**
     * Obtiene el método HTTP
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Obtiene la URI
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Obtiene un valor del request
     */
    public function input(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? $default;
    }

    /**
     * Obtiene un valor de GET
     */
    public function query(string $key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Obtiene un valor de POST
     */
    public function post(string $key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Obtiene un parámetro de la ruta
     */
    public function param(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * Establece parámetros de la ruta
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Obtiene todos los parámetros
     */
    public function params(): array
    {
        return $this->params;
    }

    /**
     * Verifica si es petición AJAX
     */
    public function ajax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Verifica si es petición POST
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    /**
     * Verifica si es petición GET
     */
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    /**
     * Obtiene un header
     */
    public function header(string $key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    /**
     * Obtiene la URI actual
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = str_replace('\\', '/', $uri);
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        $scriptDir = str_replace('\\', '/', $scriptDir);
        
        if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }

        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        return $uri;
    }

    /**
     * Obtiene los headers
     */
    private function getHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    /**
     * Recopila los datos del request
     */
    private function collectData(): array
    {
        $data = [];
        
        if ($this->method === 'POST') {
            $data = $_POST;
        } elseif ($this->method === 'GET') {
            $data = $_GET;
        }

        // Parsear JSON si existe
        $input = file_get_contents('php://input');
        if (!empty($input)) {
            $json = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = array_merge($data, $json);
            }
        }

        return $data;
    }

    /**
     * Verifica si el request tiene un campo
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Obtiene todos los datos
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Obtiene solo los campos especificados
     */
    public function only(array $keys): array
    {
        return array_intersect_key($this->data, array_flip($keys));
    }

    /**
     * Obtiene todos los datos excepto los especificados
     */
    public function except(array $keys): array
    {
        return array_diff_key($this->data, array_flip($keys));
    }
}

