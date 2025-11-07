<?php
/**
 * Clase base para todos los controladores
 */

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Core\View;

abstract class Controller
{
    /**
     * Renderiza una vista
     */
    protected function view(string $view, array $data = [], int $statusCode = 200): Response
    {
        return Response::view($view, $data, $statusCode);
    }

    /**
     * Retorna una respuesta JSON
     */
    protected function json(array $data, int $statusCode = 200): Response
    {
        return Response::json($data, $statusCode);
    }

    /**
     * Redirige a una URL
     */
    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return Response::redirect($url, $statusCode);
    }

    /**
     * Retorna una respuesta de redirección hacia atrás
     */
    protected function back(): Response
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? url('/');
        return $this->redirect($referer);
    }

    /**
     * Renderiza una vista sin layout
     */
    protected function renderPartial(string $view, array $data = []): string
    {
        return View::render($view, $data, false);
    }
}

