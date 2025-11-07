<?php
/**
 * Controlador de Tutor (Docente)
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tutoria;
use App\Models\Ficha;

class TutorController extends Controller
{
    public function __construct()
    {
        // Verificar autenticación
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'docente') {
            $this->redirect('/login');
            exit;
        }
    }

    /**
     * Dashboard del tutor
     */
    public function dashboard()
    {
        $tutoriaModel = new Tutoria();
        $docenteId = $_SESSION['usuario']['id'];
        
        // Obtener estadísticas
        $solicitudesPendientes = $tutoriaModel->countByEstado('pendiente', $docenteId);
        $tutoriasConfirmadas = $tutoriaModel->countByEstado('confirmada', $docenteId);
        
        $this->render('tutor/dashboard', [
            'solicitudesPendientes' => $solicitudesPendientes,
            'tutoriasConfirmadas' => $tutoriasConfirmadas
        ]);
    }

    /**
     * Lista de solicitudes de tutoría
     */
    public function solicitudes()
    {
        $tutoriaModel = new Tutoria();
        $docenteId = $_SESSION['usuario']['id'];
        
        $solicitudes = $tutoriaModel->getByDocente($docenteId, 'pendiente');
        
        $this->render('tutor/solicitudes', [
            'solicitudes' => $solicitudes
        ]);
    }

    /**
     * Acepta una solicitud de tutoría
     */
    public function aceptarSolicitud($id)
    {
        $this->procesarSolicitud($id, 'aceptar');
    }

    /**
     * Rechaza una solicitud de tutoría
     */
    public function rechazarSolicitud($id)
    {
        $this->procesarSolicitud($id, 'rechazar');
    }

    /**
     * Procesa la aceptación/rechazo de solicitud
     */
    private function procesarSolicitud($id, $accion)
    {
        $tutoriaModel = new Tutoria();
        $tutoria = $tutoriaModel->find($id);
        
        if (!$tutoria) {
            $_SESSION['error'] = 'Solicitud no encontrada';
            $this->redirect('/tutor/solicitudes');
            return;
        }
        
        // Verificar que el docente sea el dueño de la tutoría
        $sql = "SELECT id FROM docentes WHERE usuario_id = :usuario_id";
        $docente = $tutoriaModel->queryOne($sql, ['usuario_id' => $_SESSION['usuario']['id']]);
        
        if (!$docente || $tutoria['docente_id'] != $docente['id']) {
            $_SESSION['error'] = 'No tienes permiso para procesar esta solicitud';
            $this->redirect('/tutor/solicitudes');
            return;
        }

        $estado = $accion === 'aceptar' ? 'confirmada' : 'cancelada';
        
        if ($tutoriaModel->update($id, ['estado' => $estado])) {
            $_SESSION['success'] = $accion === 'aceptar' 
                ? 'Solicitud aceptada' 
                : 'Solicitud rechazada';
        } else {
            $_SESSION['error'] = 'Error al procesar la solicitud';
        }
        
        $this->redirect('/tutor/solicitudes');
    }

    /**
     * Lista de tutorías
     */
    public function tutorias()
    {
        $tutoriaModel = new Tutoria();
        $docenteId = $_SESSION['usuario']['id'];
        
        $tutorias = $tutoriaModel->getByDocente($docenteId);
        
        $this->render('tutor/tutorias', [
            'tutorias' => $tutorias
        ]);
    }

    /**
     * Formulario de ficha de tutoría
     */
    public function ficha($tutoriaId)
    {
        $tutoriaModel = new Tutoria();
        $fichaModel = new Ficha();
        
        $tutoria = $tutoriaModel->find($tutoriaId);
        
        if (!$tutoria) {
            $_SESSION['error'] = 'Tutoría no encontrada';
            $this->redirect('/tutor/tutorias');
            return;
        }
        
        // Verificar que el docente sea el dueño de la tutoría
        $sql = "SELECT id FROM docentes WHERE usuario_id = :usuario_id";
        $docente = $tutoriaModel->queryOne($sql, ['usuario_id' => $_SESSION['usuario']['id']]);
        
        if (!$docente || $tutoria['docente_id'] != $docente['id']) {
            $_SESSION['error'] = 'No tienes permiso para ver esta tutoría';
            $this->redirect('/tutor/tutorias');
            return;
        }
        
        // Obtener información completa de la tutoría
        $sql = "SELECT t.*, 
                e.nombres as estudiante_nombres, e.apellidos as estudiante_apellidos,
                d.nombres as docente_nombres, d.apellidos as docente_apellidos
                FROM tutorias t
                INNER JOIN estudiantes e ON t.estudiante_id = e.id
                INNER JOIN docentes d ON t.docente_id = d.id
                WHERE t.id = :id";
        $tutoriaCompleta = $tutoriaModel->queryOne($sql, ['id' => $tutoriaId]);
        
        $ficha = $fichaModel->getByTutoria($tutoriaId);
        
        $this->render('tutor/ficha', [
            'tutoria' => $tutoriaCompleta,
            'ficha' => $ficha
        ]);
    }

    /**
     * Guarda o actualiza la ficha de tutoría
     */
    public function guardarFicha($tutoriaId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/tutor/ficha/' . $tutoriaId);
            return;
        }

        $fichaModel = new Ficha();
        $tutoriaModel = new Tutoria();
        
        $tutoria = $tutoriaModel->find($tutoriaId);
        
        if (!$tutoria) {
            $_SESSION['error'] = 'Tutoría no encontrada';
            $this->redirect('/tutor/tutorias');
            return;
        }
        
        // Verificar que el docente sea el dueño de la tutoría
        $sql = "SELECT id FROM docentes WHERE usuario_id = :usuario_id";
        $docente = $tutoriaModel->queryOne($sql, ['usuario_id' => $_SESSION['usuario']['id']]);
        
        if (!$docente || $tutoria['docente_id'] != $docente['id']) {
            $_SESSION['error'] = 'No tienes permiso para editar esta tutoría';
            $this->redirect('/tutor/tutorias');
            return;
        }

        $data = [
            'tutoria_id' => $tutoriaId,
            'problematica' => $this->post('problematica'),
            'acciones' => $this->post('acciones'),
            'conclusiones' => $this->post('conclusiones')
        ];

        $fichaExistente = $fichaModel->getByTutoria($tutoriaId);
        
        if ($fichaExistente) {
            $fichaModel->update($fichaExistente['id'], $data);
            $_SESSION['success'] = 'Ficha actualizada correctamente';
        } else {
            $fichaModel->create($data);
            $_SESSION['success'] = 'Ficha creada correctamente';
        }

        // Marcar tutoría como realizada
        $tutoriaModel->update($tutoriaId, ['estado' => 'realizada']);

        $this->redirect('/tutor/tutorias');
    }
}

