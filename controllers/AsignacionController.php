<?php
require_once 'controllers/AuthController.php';
require_once 'models/Asignacion.php';
require_once 'models/Estudiante.php';
require_once 'models/Tutor.php';

class AsignacionController {
    
    // ==========================================
    // LISTAR ASIGNACIONES (COORDINADOR)
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['coordinador']);
        
        $asignacionModel = new Asignacion();
        $asignaciones = $asignacionModel->getAll();
        
        // Estadísticas
        $estudianteModel = new Estudiante();
        $tutorModel = new Tutor();
        
        $total_estudiantes = count($estudianteModel->getAll());
        $estudiantes_sin_asignacion = $asignacionModel->getEstudiantesSinAsignacion();
        $total_sin_asignar = count($estudiantes_sin_asignacion);
        
        require_once 'views/asignacion/index.php';
    }

    // ==========================================
    // CREAR ASIGNACIÓN
    // ==========================================
    
    public function create() {
        AuthController::checkRole(['coordinador']);
        
        $asignacionModel = new Asignacion();
        $estudianteModel = new Estudiante();
        $tutorModel = new Tutor();
        
        // Obtener estudiantes sin asignación
        $estudiantes = $asignacionModel->getEstudiantesSinAsignacion();
        $tutores = $tutorModel->getAll();
        
        // Agregar contador de asignados a cada tutor
        foreach ($tutores as &$tutor) {
            $tutor['total_asignados'] = $asignacionModel->countByDocente($tutor['id']);
        }
        
        require_once 'views/asignacion/form.php';
    }

    // Guardar asignación
    public function store() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $estudiante_id = $_POST['estudiante_id'];
            $docente_id = $_POST['docente_id'];
            
            // Validaciones
            $errors = [];
            
            if (empty($estudiante_id)) {
                $errors[] = 'Debe seleccionar un estudiante';
            }
            
            if (empty($docente_id)) {
                $errors[] = 'Debe seleccionar un docente/tutor';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: index.php?c=asignacion&a=create');
                exit();
            }
            
            // Crear asignación
            $asignacion = new Asignacion();
            $asignacion->estudiante_id = $estudiante_id;
            $asignacion->docente_id = $docente_id;
            $asignacion->fecha_asignacion = date('Y-m-d');
            
            if ($asignacion->create()) {
                $_SESSION['success'] = 'Asignación creada correctamente';
                header('Location: index.php?c=asignacion');
                exit();
            } else {
                $_SESSION['error'] = 'Error al crear la asignación';
                header('Location: index.php?c=asignacion&a=create');
                exit();
            }
        }
    }

    // ==========================================
    // REASIGNAR ESTUDIANTE
    // ==========================================
    
    public function reasignar() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        
        $asignacionModel = new Asignacion();
        $asignacion = $asignacionModel->getById($id);
        
        if (!$asignacion) {
            $_SESSION['error'] = 'Asignación no encontrada';
            header('Location: index.php?c=asignacion');
            exit();
        }
        
        // Obtener todos los tutores (excepto el actual)
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        // Agregar contador de asignados a cada tutor
        foreach ($tutores as &$tutor) {
            $tutor['total_asignados'] = $asignacionModel->countByDocente($tutor['id']);
        }
        
        require_once 'views/asignacion/reasignar.php';
    }

    // Guardar reasignación
    public function guardarReasignacion() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nuevo_docente_id = $_POST['docente_id'];
            $motivo = trim($_POST['motivo']);
            
            // Validaciones
            $errors = [];
            
            if (empty($nuevo_docente_id)) {
                $errors[] = 'Debe seleccionar el nuevo docente/tutor';
            }
            
            if (empty($motivo)) {
                $errors[] = 'El motivo de la reasignación es obligatorio';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=asignacion&a=reasignar&id=' . $id);
                exit();
            }
            
            // Verificar que el nuevo docente sea diferente al actual
            $asignacionModel = new Asignacion();
            $asignacion_actual = $asignacionModel->getById($id);
            
            if ($asignacion_actual['docente_id'] == $nuevo_docente_id) {
                $_SESSION['error'] = 'Debe seleccionar un docente diferente al actual';
                header('Location: index.php?c=asignacion&a=reasignar&id=' . $id);
                exit();
            }
            
            // Realizar reasignación
            if ($asignacionModel->reasignar($id, $nuevo_docente_id, $motivo)) {
                $_SESSION['success'] = 'Estudiante reasignado correctamente';
                header('Location: index.php?c=asignacion');
                exit();
            } else {
                $_SESSION['error'] = 'Error al reasignar el estudiante';
                header('Location: index.php?c=asignacion&a=reasignar&id=' . $id);
                exit();
            }
        }
    }

    // ==========================================
    // HISTORIAL DE REASIGNACIONES
    // ==========================================
    
    public function historial() {
        AuthController::checkAuth();
        
        $estudiante_id = $_GET['id'];
        
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($estudiante_id);
        
        if (!$estudiante) {
            $_SESSION['error'] = 'Estudiante no encontrado';
            header('Location: index.php?c=asignacion');
            exit();
        }
        
        $asignacionModel = new Asignacion();
        $historial = $asignacionModel->getHistorialReasignaciones($estudiante_id);
        $asignacion_actual = $asignacionModel->getByEstudiante($estudiante_id);
        
        require_once 'views/asignacion/historial.php';
    }

    // ==========================================
    // MIS ESTUDIANTES ASIGNADOS (DOCENTE)
    // ==========================================
    
    public function misAsignados() {
        AuthController::checkRole(['docente']);
        
        // Obtener docente_id del usuario logueado
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        $asignacionModel = new Asignacion();
        $estudiantes_asignados = $asignacionModel->getByDocente($docente_id);
        
        require_once 'views/asignacion/mis_asignados.php';
    }

    // ==========================================
    // ELIMINAR ASIGNACIÓN
    // ==========================================
    
    public function delete() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        
        $asignacionModel = new Asignacion();
        
        if ($asignacionModel->delete($id)) {
            $_SESSION['success'] = 'Asignación eliminada correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar la asignación';
        }
        
        header('Location: index.php?c=asignacion');
        exit();
    }

    // ==========================================
    // UTILIDADES
    // ==========================================
    
    private function getDocenteId() {
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        foreach ($tutores as $tutor) {
            if ($tutor['usuario_id'] == $_SESSION['user_id']) {
                return $tutor['id'];
            }
        }
        
        return null;
    }
}
