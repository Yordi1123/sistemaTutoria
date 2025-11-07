<?php
/**
 * Controlador de Coordinador
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Models\Tutoria;

class CoordinadorController extends Controller
{
    public function __construct()
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'coordinador') {
            $this->redirect('/login');
            exit;
        }
    }

    /**
     * Dashboard del coordinador
     */
    public function dashboard()
    {
        $tutoriaModel = new Tutoria();
        $usuarioModel = new Usuario();
        
        // Obtener estadísticas
        $totalTutorias = $tutoriaModel->countAll();
        $tutoriasPendientes = $tutoriaModel->countByEstado('pendiente');
        $totalTutores = $usuarioModel->countByRol('docente');
        $totalEstudiantes = $usuarioModel->countByRol('estudiante');
        
        $this->render('coordinador/dashboard', [
            'totalTutorias' => $totalTutorias,
            'tutoriasPendientes' => $tutoriasPendientes,
            'totalTutores' => $totalTutores,
            'totalEstudiantes' => $totalEstudiantes
        ]);
    }

    /**
     * Lista de tutores
     */
    public function tutores()
    {
        $usuarioModel = new Usuario();
        $tutores = $usuarioModel->getByRol('docente');
        
        $this->render('coordinador/tutores', [
            'tutores' => $tutores
        ]);
    }

    /**
     * Lista de estudiantes
     */
    public function estudiantes()
    {
        $usuarioModel = new Usuario();
        $estudiantes = $usuarioModel->getByRol('estudiante');
        
        $this->render('coordinador/estudiantes', [
            'estudiantes' => $estudiantes
        ]);
    }

    /**
     * Reportes
     */
    public function reportes()
    {
        $tutoriaModel = new Tutoria();
        
        // Obtener reportes
        $tutoriasPorEstado = $tutoriaModel->getStatsByEstado();
        $tutoriasPorMes = $tutoriaModel->getStatsByMonth();
        
        $this->render('coordinador/reportes', [
            'tutoriasPorEstado' => $tutoriasPorEstado,
            'tutoriasPorMes' => $tutoriasPorMes
        ]);
    }
}

