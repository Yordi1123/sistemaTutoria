<?php
/**
 * Controlador de inicio
 */

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;

class HomeController extends Controller
{
    /**
     * Página de inicio
     */
    public function index(Request $request): Response
    {
        $data = [
            'title' => 'Inicio - Sistema Académico',
            'message' => 'Bienvenido al Sistema Académico'
        ];
        return $this->view('home.index', $data);
    }

    /**
     * Página 404
     */
    public function notFound(): Response
    {
        $data = [
            'title' => '404 - Página no encontrada'
        ];
        return $this->view('errors.404', $data, 404);
    }
}

