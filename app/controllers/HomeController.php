<?php
/**
 * Controlador de inicio
 */

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    /**
     * Página de inicio
     */
    public function index()
    {
        $data = [
            'title' => 'Inicio - Sistema Académico',
            'message' => 'Bienvenido al Sistema Académico'
        ];
        $this->render('home/index', $data);
    }

    /**
     * Página 404
     */
    public function notFound()
    {
        http_response_code(404);
        $data = [
            'title' => '404 - Página no encontrada'
        ];
        $this->render('errors/404', $data);
    }
}
