<?php
/**
 * Clase Response para manejar respuestas HTTP
 */

namespace App\Http;

class Response
{
    private $content;
    private $statusCode;
    private $headers;

    public function __construct($content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * Establece el contenido
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Establece el código de estado
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Agrega un header
     */
    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Retorna una respuesta JSON
     */
    public static function json(array $data, int $statusCode = 200): self
    {
        $response = new self(json_encode($data, JSON_UNESCAPED_UNICODE), $statusCode);
        $response->header('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    /**
     * Redirige a una URL
     */
    public static function redirect(string $url, int $statusCode = 302): self
    {
        $response = new self('', $statusCode);
        $response->header('Location', $url);
        return $response;
    }

    /**
     * Retorna una respuesta de vista
     */
    public static function view(string $view, array $data = [], int $statusCode = 200): self
    {
        $viewContent = \App\Core\View::render($view, $data);
        return new self($viewContent, $statusCode);
    }

    /**
     * Envía la respuesta
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->content;
        exit;
    }

    /**
     * Obtiene el contenido
     */
    public function getContent()
    {
        return $this->content;
    }
}

