<?php
/**
 * Controlador de Estudiante
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tutoria;

class EstudianteController extends Controller
{
    public function __construct()
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
            $this->redirect('/login');
            exit;
        }
    }

    /**
     * Dashboard del estudiante
     */
    public function dashboard()
    {
        $tutoriaModel = new Tutoria();
        $estudianteId = $_SESSION['usuario']['id'];
        
        // Obtener tutorías del estudiante
        $tutorias = $tutoriaModel->getByEstudiante($estudianteId);
        
        $this->render('estudiante/dashboard', [
            'tutorias' => $tutorias
        ]);
    }

    /**
     * Formulario para solicitar tutoría
     */
    public function solicitar()
    {
        // Obtener lista de docentes disponibles
        $usuarioModel = new \App\Models\Usuario();
        $docentes = $usuarioModel->getDocentesList();
        
        $this->render('estudiante/solicitar', [
            'docentes' => $docentes
        ]);
    }

    /**
     * Procesa la solicitud de tutoría
     */
    public function storeSolicitud()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/estudiante/solicitar');
            return;
        }

        // Validar campos
        $docenteId = $this->post('docente_id');
        $fecha = $this->post('fecha');
        $hora = $this->post('hora');
        $motivo = $this->post('motivo');

        if (empty($docenteId) || empty($fecha) || empty($hora) || empty($motivo)) {
            $_SESSION['error'] = 'Por favor, complete todos los campos';
            $this->redirect('/estudiante/solicitar');
            return;
        }

        $tutoriaModel = new Tutoria();
        
        // El create del modelo maneja la conversión de usuario_id a estudiante_id
        $data = [
            'estudiante_id' => $_SESSION['usuario']['id'],
            'docente_id' => $docenteId, // Este es el docente_id real de la tabla docentes
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo' => $motivo,
            'estado' => 'pendiente'
        ];

        if ($tutoriaModel->create($data)) {
            $_SESSION['success'] = 'Tutoría solicitada correctamente';
            $this->redirect('/estudiante/mis-tutorias');
        } else {
            $_SESSION['error'] = 'Error al solicitar la tutoría';
            $this->redirect('/estudiante/solicitar');
        }
    }

    /**
     * Mis tutorías
     */
    public function misTutorias()
    {
        $tutoriaModel = new Tutoria();
        $estudianteId = $_SESSION['usuario']['id'];
        
        $tutorias = $tutoriaModel->getByEstudiante($estudianteId);
        
        $this->render('estudiante/mis-tutorias', [
            'tutorias' => $tutorias
        ]);
    }
}

