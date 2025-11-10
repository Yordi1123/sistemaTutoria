<?php
require_once 'controllers/AuthController.php';
require_once 'models/Usuario.php';
require_once 'models/Estudiante.php';
require_once 'models/Tutor.php';

class DashboardController {
    
    // Dashboard para Administrador/Coordinador
    public function admin() {
        // Verificar autenticación y rol
        AuthController::checkRole(['coordinador']);
        
        // Obtener estadísticas
        $estudianteModel = new Estudiante();
        $tutorModel = new Tutor();
        $usuarioModel = new Usuario();
        
        $totalEstudiantes = count($estudianteModel->getAll());
        $totalTutores = count($tutorModel->getAll());
        $totalUsuarios = count($usuarioModel->getAll());
        
        require_once 'views/dashboard/admin.php';
    }
    
    // Dashboard para Docente
    public function docente() {
        // Verificar autenticación y rol
        AuthController::checkRole(['docente']);
        
        // Obtener información del docente
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        // Aquí puedes agregar más lógica específica del docente
        
        require_once 'views/dashboard/docente.php';
    }
    
    // Dashboard para Estudiante
    public function estudiante() {
        // Verificar autenticación y rol
        AuthController::checkRole(['estudiante']);
        
        // Obtener estudiante_id del usuario logueado
        require_once 'models/Tutoria.php';
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        $estudiante_id = null;
        
        foreach ($estudiantes as $est) {
            if ($est['usuario_id'] == $_SESSION['user_id']) {
                $estudiante_id = $est['id'];
                break;
            }
        }
        
        // Obtener estadísticas y próximas tutorías
        $estadisticas = ['pendientes' => 0, 'realizadas' => 0, 'total' => 0];
        $proximasTutorias = [];
        $tutoriasHoy = [];
        
        if ($estudiante_id) {
            $tutoriaModel = new Tutoria();
            $estadisticas = $tutoriaModel->getEstadisticas($estudiante_id);
            $proximasTutorias = $tutoriaModel->getProximas($estudiante_id, 5);
            $tutoriasHoy = $tutoriaModel->getTutoriasHoy($estudiante_id);
        }
        
        require_once 'views/dashboard/estudiante.php';
    }
}

