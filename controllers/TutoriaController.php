<?php
require_once 'controllers/AuthController.php';
require_once 'models/Tutoria.php';
require_once 'models/Tutor.php';
require_once 'models/Estudiante.php';

class TutoriaController {
    
    // ==========================================
    // SOLICITAR TUTORÍA
    // ==========================================
    
    public function solicitar() {
        AuthController::checkRole(['estudiante']);
        
        // Obtener lista de tutores disponibles
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        require_once 'views/tutoria/solicitar.php';
    }

    // Guardar solicitud de tutoría
    public function store() {
        AuthController::checkRole(['estudiante']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            
            // Obtener estudiante_id del usuario logueado
            $estudianteModel = new Estudiante();
            $estudiantes = $estudianteModel->getAll();
            $estudiante_id = null;
            
            // Buscar el estudiante_id correspondiente al usuario logueado
            foreach ($estudiantes as $est) {
                if ($est['usuario_id'] == $_SESSION['user_id']) {
                    $estudiante_id = $est['id'];
                    break;
                }
            }
            
            if (!$estudiante_id) {
                $_SESSION['error'] = 'No se encontró perfil de estudiante asociado';
                header('Location: index.php?c=tutoria&a=solicitar');
                exit();
            }
            
            $docente_id = $_POST['docente_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo = trim($_POST['motivo']);
            
            // Validaciones
            if (empty($docente_id) || empty($fecha) || empty($hora) || empty($motivo)) {
                $errors[] = 'Todos los campos son obligatorios';
            }
            
            // Validar que la fecha sea futura
            $fecha_seleccionada = strtotime($fecha);
            $hoy = strtotime(date('Y-m-d'));
            
            if ($fecha_seleccionada < $hoy) {
                $errors[] = 'La fecha debe ser hoy o futura';
            }
            
            // Verificar conflicto de horario
            $tutoriaModel = new Tutoria();
            if ($tutoriaModel->verificarConflicto($docente_id, $fecha, $hora)) {
                $errors[] = 'El tutor ya tiene una sesión programada en ese horario';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=tutoria&a=solicitar');
                exit();
            }
            
            // Crear la tutoría
            $tutoria = new Tutoria();
            $tutoria->estudiante_id = $estudiante_id;
            $tutoria->docente_id = $docente_id;
            $tutoria->fecha = $fecha;
            $tutoria->hora = $hora;
            $tutoria->motivo = $motivo;
            
            if ($tutoria->create()) {
                $_SESSION['success'] = 'Solicitud de tutoría enviada correctamente. Estado: Pendiente';
                header('Location: index.php?c=dashboard&a=estudiante');
                exit();
            } else {
                $_SESSION['error'] = 'Error al solicitar tutoría';
                header('Location: index.php?c=tutoria&a=solicitar');
                exit();
            }
        }
    }

    // ==========================================
    // MIS TUTORÍAS (ESTUDIANTE)
    // ==========================================
    
    public function mistutorias() {
        AuthController::checkRole(['estudiante']);
        
        // Obtener estudiante_id
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        $estudiante_id = null;
        
        foreach ($estudiantes as $est) {
            if ($est['usuario_id'] == $_SESSION['user_id']) {
                $estudiante_id = $est['id'];
                break;
            }
        }
        
        if (!$estudiante_id) {
            $_SESSION['error'] = 'No se encontró perfil de estudiante';
            header('Location: index.php?c=dashboard&a=estudiante');
            exit();
        }
        
        $tutoriaModel = new Tutoria();
        $tutorias = $tutoriaModel->getByEstudiante($estudiante_id);
        
        require_once 'views/tutoria/mistutorias.php';
    }

    // ==========================================
    // HISTORIAL
    // ==========================================
    
    public function historial() {
        AuthController::checkRole(['estudiante']);
        
        // Obtener estudiante_id
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        $estudiante_id = null;
        
        foreach ($estudiantes as $est) {
            if ($est['usuario_id'] == $_SESSION['user_id']) {
                $estudiante_id = $est['id'];
                break;
            }
        }
        
        if (!$estudiante_id) {
            $_SESSION['error'] = 'No se encontró perfil de estudiante';
            header('Location: index.php?c=dashboard&a=estudiante');
            exit();
        }
        
        // Obtener filtro si existe
        $filtro_estado = isset($_GET['estado']) ? $_GET['estado'] : null;
        
        $tutoriaModel = new Tutoria();
        $tutorias = $tutoriaModel->getHistorial($estudiante_id, $filtro_estado);
        $estadisticas = $tutoriaModel->getEstadisticas($estudiante_id);
        
        require_once 'views/tutoria/historial.php';
    }

    // ==========================================
    // DETALLE DE TUTORÍA
    // ==========================================
    
    public function detalle() {
        AuthController::checkAuth();
        
        $id = $_GET['id'];
        $tutoriaModel = new Tutoria();
        $tutoria = $tutoriaModel->getById($id);
        
        if (!$tutoria) {
            $_SESSION['error'] = 'Tutoría no encontrada';
            header('Location: index.php?c=dashboard&a=estudiante');
            exit();
        }
        
        require_once 'views/tutoria/detalle.php';
    }

    // ==========================================
    // CONFIRMAR ASISTENCIA
    // ==========================================
    
    public function asistencia() {
        AuthController::checkRole(['estudiante']);
        
        // Obtener estudiante_id
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        $estudiante_id = null;
        
        foreach ($estudiantes as $est) {
            if ($est['usuario_id'] == $_SESSION['user_id']) {
                $estudiante_id = $est['id'];
                break;
            }
        }
        
        if (!$estudiante_id) {
            $_SESSION['error'] = 'No se encontró perfil de estudiante';
            header('Location: index.php?c=dashboard&a=estudiante');
            exit();
        }
        
        $tutoriaModel = new Tutoria();
        $tutoriasHoy = $tutoriaModel->getTutoriasHoy($estudiante_id);
        
        require_once 'views/tutoria/asistencia.php';
    }

    // Confirmar asistencia a una tutoría
    public function confirmar() {
        AuthController::checkRole(['estudiante']);
        
        $id = $_GET['id'];
        $tutoriaModel = new Tutoria();
        
        if ($tutoriaModel->confirmarAsistencia($id)) {
            $_SESSION['success'] = 'Asistencia confirmada correctamente';
        } else {
            $_SESSION['error'] = 'Error al confirmar asistencia';
        }
        
        header('Location: index.php?c=tutoria&a=asistencia');
        exit();
    }

    // ==========================================
    // CANCELAR TUTORÍA
    // ==========================================
    
    public function cancelar() {
        AuthController::checkRole(['estudiante']);
        
        // Obtener estudiante_id
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        $estudiante_id = null;
        
        foreach ($estudiantes as $est) {
            if ($est['usuario_id'] == $_SESSION['user_id']) {
                $estudiante_id = $est['id'];
                break;
            }
        }
        
        $id = $_GET['id'];
        $tutoriaModel = new Tutoria();
        
        if ($tutoriaModel->cancelar($id, $estudiante_id)) {
            $_SESSION['success'] = 'Tutoría cancelada correctamente';
        } else {
            $_SESSION['error'] = 'No se pudo cancelar la tutoría. Solo se pueden cancelar tutorías pendientes.';
        }
        
        header('Location: index.php?c=tutoria&a=mistutorias');
        exit();
    }

    // ==========================================
    // ADMIN - VER TODAS LAS TUTORÍAS
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['coordinador']);
        
        $tutoriaModel = new Tutoria();
        $tutorias = $tutoriaModel->getAll();
        
        require_once 'views/tutoria/index.php';
    }
}

