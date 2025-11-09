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
        
        // Obtener información del estudiante
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        
        // Aquí puedes agregar más lógica específica del estudiante
        
        require_once 'views/dashboard/estudiante.php';
    }
}

