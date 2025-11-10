<?php
require_once 'controllers/AuthController.php';
require_once 'models/Seguimiento.php';
require_once 'models/Tutor.php';
require_once 'models/Estudiante.php';

class SeguimientoController {
    
    // Obtener docente_id del usuario logueado
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

    // ==========================================
    // LISTAR ESTUDIANTES PARA SEGUIMIENTO
    // ==========================================
    
    public function estudiantes() {
        AuthController::checkRole(['docente']);
        
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        
        // Obtener último seguimiento de cada estudiante
        $seguimientoModel = new Seguimiento();
        foreach ($estudiantes as &$estudiante) {
            $ultimo = $seguimientoModel->getUltimoByEstudiante($estudiante['id']);
            $estudiante['ultimo_seguimiento'] = $ultimo;
        }
        
        require_once 'views/seguimiento/estudiantes.php';
    }

    // ==========================================
    // VER SEGUIMIENTOS DE UN ESTUDIANTE
    // ==========================================
    
    public function ver() {
        AuthController::checkAuth();
        
        $estudiante_id = $_GET['id'];
        
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($estudiante_id);
        
        if (!$estudiante) {
            $_SESSION['error'] = 'Estudiante no encontrado';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        $seguimientoModel = new Seguimiento();
        $seguimientos = $seguimientoModel->getByEstudiante($estudiante_id);
        $evolucion = $seguimientoModel->getEvolucion($estudiante_id);
        
        require_once 'views/seguimiento/ver.php';
    }

    // ==========================================
    // CREAR SEGUIMIENTO
    // ==========================================
    
    public function crear() {
        AuthController::checkRole(['docente']);
        
        $estudiante_id = $_GET['id'];
        
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($estudiante_id);
        
        if (!$estudiante) {
            $_SESSION['error'] = 'Estudiante no encontrado';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        require_once 'views/seguimiento/form.php';
    }

    // Guardar seguimiento
    public function guardar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $estudiante_id = $_POST['estudiante_id'];
            $fecha = $_POST['fecha'];
            $tipo = $_POST['tipo'];
            $observaciones = trim($_POST['observaciones']);
            $recomendaciones = trim($_POST['recomendaciones']);
            $estado_animo = $_POST['estado_animo'];
            $nivel_avance = $_POST['nivel_avance'];
            $requiere_atencion = isset($_POST['requiere_atencion']) ? 1 : 0;
            
            // Validaciones
            $errors = [];
            
            if (empty($fecha)) {
                $errors[] = 'La fecha es requerida';
            }
            
            if (empty($tipo)) {
                $errors[] = 'El tipo de seguimiento es requerido';
            }
            
            if (empty($observaciones)) {
                $errors[] = 'Las observaciones son requeridas';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=seguimiento&a=crear&id=' . $estudiante_id);
                exit();
            }
            
            // Crear seguimiento
            $docente_id = $this->getDocenteId();
            
            $seguimiento = new Seguimiento();
            $seguimiento->estudiante_id = $estudiante_id;
            $seguimiento->docente_id = $docente_id;
            $seguimiento->fecha = $fecha;
            $seguimiento->tipo = $tipo;
            $seguimiento->observaciones = $observaciones;
            $seguimiento->recomendaciones = $recomendaciones;
            $seguimiento->estado_animo = $estado_animo;
            $seguimiento->nivel_avance = $nivel_avance;
            $seguimiento->requiere_atencion = $requiere_atencion;
            
            if ($seguimiento->create()) {
                $_SESSION['success'] = 'Seguimiento registrado correctamente';
                header('Location: index.php?c=seguimiento&a=ver&id=' . $estudiante_id);
                exit();
            } else {
                $_SESSION['error'] = 'Error al registrar el seguimiento';
                header('Location: index.php?c=seguimiento&a=crear&id=' . $estudiante_id);
                exit();
            }
        }
    }

    // ==========================================
    // EDITAR SEGUIMIENTO
    // ==========================================
    
    public function editar() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        
        $seguimientoModel = new Seguimiento();
        $seguimiento = $seguimientoModel->getById($id);
        
        if (!$seguimiento) {
            $_SESSION['error'] = 'Seguimiento no encontrado';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        // Verificar que el seguimiento pertenece al docente
        $docente_id = $this->getDocenteId();
        if ($seguimiento['docente_id'] != $docente_id) {
            $_SESSION['error'] = 'No tienes permiso para editar este seguimiento';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        // Obtener información del estudiante
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($seguimiento['estudiante_id']);
        
        require_once 'views/seguimiento/form.php';
    }

    // Actualizar seguimiento
    public function actualizar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $estudiante_id = $_POST['estudiante_id'];
            $fecha = $_POST['fecha'];
            $tipo = $_POST['tipo'];
            $observaciones = trim($_POST['observaciones']);
            $recomendaciones = trim($_POST['recomendaciones']);
            $estado_animo = $_POST['estado_animo'];
            $nivel_avance = $_POST['nivel_avance'];
            $requiere_atencion = isset($_POST['requiere_atencion']) ? 1 : 0;
            
            // Validaciones
            $errors = [];
            
            if (empty($fecha)) {
                $errors[] = 'La fecha es requerida';
            }
            
            if (empty($tipo)) {
                $errors[] = 'El tipo de seguimiento es requerido';
            }
            
            if (empty($observaciones)) {
                $errors[] = 'Las observaciones son requeridas';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=seguimiento&a=editar&id=' . $id);
                exit();
            }
            
            // Actualizar seguimiento
            $seguimiento = new Seguimiento();
            $seguimiento->id = $id;
            $seguimiento->fecha = $fecha;
            $seguimiento->tipo = $tipo;
            $seguimiento->observaciones = $observaciones;
            $seguimiento->recomendaciones = $recomendaciones;
            $seguimiento->estado_animo = $estado_animo;
            $seguimiento->nivel_avance = $nivel_avance;
            $seguimiento->requiere_atencion = $requiere_atencion;
            
            if ($seguimiento->update()) {
                $_SESSION['success'] = 'Seguimiento actualizado correctamente';
                header('Location: index.php?c=seguimiento&a=ver&id=' . $estudiante_id);
                exit();
            } else {
                $_SESSION['error'] = 'Error al actualizar el seguimiento';
                header('Location: index.php?c=seguimiento&a=editar&id=' . $id);
                exit();
            }
        }
    }

    // ==========================================
    // ELIMINAR SEGUIMIENTO
    // ==========================================
    
    public function eliminar() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        
        $seguimientoModel = new Seguimiento();
        $seguimiento = $seguimientoModel->getById($id);
        
        if (!$seguimiento) {
            $_SESSION['error'] = 'Seguimiento no encontrado';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        // Verificar que el seguimiento pertenece al docente
        $docente_id = $this->getDocenteId();
        if ($seguimiento['docente_id'] != $docente_id) {
            $_SESSION['error'] = 'No tienes permiso para eliminar este seguimiento';
            header('Location: index.php?c=seguimiento&a=estudiantes');
            exit();
        }
        
        $estudiante_id = $seguimiento['estudiante_id'];
        
        if ($seguimientoModel->delete($id)) {
            $_SESSION['success'] = 'Seguimiento eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el seguimiento';
        }
        
        header('Location: index.php?c=seguimiento&a=ver&id=' . $estudiante_id);
        exit();
    }

    // ==========================================
    // MIS SEGUIMIENTOS
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        $seguimientoModel = new Seguimiento();
        $seguimientos = $seguimientoModel->getByDocente($docente_id);
        $requierenAtencion = $seguimientoModel->getQueRequierenAtencion($docente_id);
        
        require_once 'views/seguimiento/index.php';
    }
}

