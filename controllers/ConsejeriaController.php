<?php
require_once 'controllers/AuthController.php';
require_once 'models/Consejeria.php';
require_once 'models/Consejero.php';
require_once 'models/FichaConsejeria.php';
require_once 'models/Estudiante.php';

class ConsejeriaController {
    
    // Obtener consejero_id del usuario logueado
    private function getConsejeroId() {
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getByUsuarioId($_SESSION['user_id']);
        return $consejero ? $consejero['id'] : null;
    }

    // Obtener estudiante_id del usuario logueado
    private function getEstudianteId() {
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        
        foreach ($estudiantes as $estudiante) {
            if ($estudiante['usuario_id'] == $_SESSION['user_id']) {
                return $estudiante['id'];
            }
        }
        return null;
    }

    // ==========================================
    // DASHBOARD CONSEJERO
    // ==========================================
    
    public function dashboard() {
        AuthController::checkRole(['consejero']);
        
        $consejero_id = $this->getConsejeroId();
        
        if (!$consejero_id) {
            $_SESSION['error'] = 'No se encontró perfil de consejero';
            header('Location: index.php');
            exit();
        }
        
        $consejeriaModel = new Consejeria();
        $fichaModel = new FichaConsejeria();
        $consejeroModel = new Consejero();
        
        $consejero = $consejeroModel->getById($consejero_id);
        $solicitudes_pendientes = $consejeriaModel->countPendientes($consejero_id);
        $consejerias_hoy = $consejeriaModel->getConsejeriasHoy($consejero_id);
        $estadisticas = $consejeriaModel->getEstadisticasConsejero($consejero_id);
        $estudiantes_unicos = $consejeriaModel->countEstudiantesUnicos($consejero_id);
        $fichas_total = $fichaModel->countByConsejero($consejero_id);
        
        require_once 'views/consejeria/dashboard.php';
    }

    // ==========================================
    // SOLICITAR CONSEJERÍA (ESTUDIANTE)
    // ==========================================
    
    public function solicitar() {
        AuthController::checkRole(['estudiante']);
        
        $consejeroModel = new Consejero();
        $consejeros = $consejeroModel->getAll();
        
        require_once 'views/consejeria/solicitar.php';
    }

    public function guardar() {
        AuthController::checkRole(['estudiante']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $estudiante_id = $this->getEstudianteId();
            
            if (!$estudiante_id) {
                $_SESSION['error'] = 'No se encontró perfil de estudiante';
                header('Location: index.php?c=consejeria&a=solicitar');
                exit();
            }
            
            $consejero_id = $_POST['consejero_id'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo = trim($_POST['motivo']);
            
            // Validaciones
            $errors = [];
            
            if (empty($consejero_id) || empty($fecha) || empty($hora) || empty($motivo)) {
                $errors[] = 'Todos los campos son obligatorios';
            }
            
            if (strtotime($fecha) < strtotime(date('Y-m-d'))) {
                $errors[] = 'La fecha debe ser hoy o futura';
            }
            
            // Verificar conflicto
            $consejeriaModel = new Consejeria();
            if ($consejeriaModel->verificarConflicto($consejero_id, $fecha, $hora)) {
                $errors[] = 'El consejero ya tiene una cita en ese horario';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=consejeria&a=solicitar');
                exit();
            }
            
            // Crear consejería
            $consejeria = new Consejeria();
            $consejeria->estudiante_id = $estudiante_id;
            $consejeria->consejero_id = $consejero_id;
            $consejeria->fecha = $fecha;
            $consejeria->hora = $hora;
            $consejeria->motivo = $motivo;
            
            if ($consejeria->create()) {
                $_SESSION['success'] = 'Solicitud de consejería enviada correctamente';
                header('Location: index.php?c=consejeria&a=misConsejerias');
                exit();
            } else {
                $_SESSION['error'] = 'Error al solicitar consejería';
                header('Location: index.php?c=consejeria&a=solicitar');
                exit();
            }
        }
    }

    // ==========================================
    // MIS CONSEJERÍAS (ESTUDIANTE)
    // ==========================================
    
    public function misConsejerias() {
        AuthController::checkRole(['estudiante']);
        
        $estudiante_id = $this->getEstudianteId();
        
        if (!$estudiante_id) {
            $_SESSION['error'] = 'No se encontró perfil de estudiante';
            header('Location: index.php?c=dashboard&a=estudiante');
            exit();
        }
        
        $consejeriaModel = new Consejeria();
        $consejerias = $consejeriaModel->getByEstudiante($estudiante_id);
        
        require_once 'views/consejeria/mis_consejerias.php';
    }

    // ==========================================
    // SOLICITUDES PENDIENTES (CONSEJERO)
    // ==========================================
    
    public function solicitudes() {
        AuthController::checkRole(['consejero']);
        
        $consejero_id = $this->getConsejeroId();
        
        if (!$consejero_id) {
            $_SESSION['error'] = 'No se encontró perfil de consejero';
            header('Location: index.php?c=consejeria&a=dashboard');
            exit();
        }
        
        $consejeriaModel = new Consejeria();
        $solicitudes = $consejeriaModel->getSolicitudesPendientes($consejero_id);
        
        require_once 'views/consejeria/solicitudes.php';
    }

    // Aprobar solicitud
    public function aprobar() {
        AuthController::checkRole(['consejero']);
        
        $id = $_GET['id'];
        $consejero_id = $this->getConsejeroId();
        
        $consejeriaModel = new Consejeria();
        
        if (!$consejeriaModel->perteneceAConsejero($id, $consejero_id)) {
            $_SESSION['error'] = 'No tienes permiso para gestionar esta consejería';
            header('Location: index.php?c=consejeria&a=solicitudes');
            exit();
        }
        
        if ($consejeriaModel->aprobar($id)) {
            $_SESSION['success'] = 'Solicitud aprobada correctamente';
        } else {
            $_SESSION['error'] = 'Error al aprobar la solicitud';
        }
        
        header('Location: index.php?c=consejeria&a=solicitudes');
        exit();
    }

    // Rechazar solicitud
    public function rechazar() {
        AuthController::checkRole(['consejero']);
        
        $id = $_GET['id'];
        $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : 'No especificado';
        $consejero_id = $this->getConsejeroId();
        
        $consejeriaModel = new Consejeria();
        
        if (!$consejeriaModel->perteneceAConsejero($id, $consejero_id)) {
            $_SESSION['error'] = 'No tienes permiso para gestionar esta consejería';
            header('Location: index.php?c=consejeria&a=solicitudes');
            exit();
        }
        
        if ($consejeriaModel->rechazar($id, $motivo)) {
            $_SESSION['success'] = 'Solicitud rechazada';
        } else {
            $_SESSION['error'] = 'Error al rechazar la solicitud';
        }
        
        header('Location: index.php?c=consejeria&a=solicitudes');
        exit();
    }

    // ==========================================
    // MIS CONSEJERÍAS (CONSEJERO)
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['consejero']);
        
        $consejero_id = $this->getConsejeroId();
        
        if (!$consejero_id) {
            $_SESSION['error'] = 'No se encontró perfil de consejero';
            header('Location: index.php?c=consejeria&a=dashboard');
            exit();
        }
        
        $consejeriaModel = new Consejeria();
        $consejerias = $consejeriaModel->getByConsejero($consejero_id);
        
        require_once 'views/consejeria/index.php';
    }

    // ==========================================
    // DETALLE DE CONSEJERÍA
    // ==========================================
    
    public function detalle() {
        AuthController::checkAuth();
        
        $id = $_GET['id'];
        
        $consejeriaModel = new Consejeria();
        $consejeria = $consejeriaModel->getById($id);
        
        if (!$consejeria) {
            $_SESSION['error'] = 'Consejería no encontrada';
            header('Location: index.php');
            exit();
        }
        
        // Obtener ficha si existe
        $fichaModel = new FichaConsejeria();
        $ficha = $fichaModel->getByConsejeria($id);
        
        require_once 'views/consejeria/detalle.php';
    }

    // ==========================================
    // MARCAR COMO REALIZADA
    // ==========================================
    
    public function marcarRealizada() {
        AuthController::checkRole(['consejero']);
        
        $id = $_GET['id'];
        $consejero_id = $this->getConsejeroId();
        
        $consejeriaModel = new Consejeria();
        
        if (!$consejeriaModel->perteneceAConsejero($id, $consejero_id)) {
            $_SESSION['error'] = 'No tienes permiso para gestionar esta consejería';
            header('Location: index.php?c=consejeria&a=index');
            exit();
        }
        
        if ($consejeriaModel->marcarRealizada($id)) {
            $_SESSION['success'] = 'Consejería marcada como realizada';
        } else {
            $_SESSION['error'] = 'Error al actualizar la consejería';
        }
        
        header('Location: index.php?c=consejeria&a=index');
        exit();
    }

    // ==========================================
    // FICHAS DE CONSEJERÍA
    // ==========================================
    
    public function crearFicha() {
        AuthController::checkRole(['consejero']);
        
        $consejeria_id = $_GET['id'];
        
        $consejeriaModel = new Consejeria();
        $consejeria = $consejeriaModel->getById($consejeria_id);
        
        if (!$consejeria) {
            $_SESSION['error'] = 'Consejería no encontrada';
            header('Location: index.php?c=consejeria&a=index');
            exit();
        }
        
        $consejero_id = $this->getConsejeroId();
        if (!$consejeriaModel->perteneceAConsejero($consejeria_id, $consejero_id)) {
            $_SESSION['error'] = 'No tienes permiso para crear esta ficha';
            header('Location: index.php?c=consejeria&a=index');
            exit();
        }
        
        // Verificar si ya existe ficha
        $fichaModel = new FichaConsejeria();
        if ($fichaModel->existe($consejeria_id)) {
            $ficha = $fichaModel->getByConsejeria($consejeria_id);
            header('Location: index.php?c=consejeria&a=editarFicha&id=' . $ficha['id']);
            exit();
        }
        
        require_once 'views/consejeria/ficha_form.php';
    }

    public function guardarFicha() {
        AuthController::checkRole(['consejero']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $consejeria_id = $_POST['consejeria_id'];
            $situacion = trim($_POST['situacion']);
            $intervencion = trim($_POST['intervencion']);
            $conclusiones = trim($_POST['conclusiones']);
            
            // Validaciones
            $errors = [];
            
            if (empty($situacion)) {
                $errors[] = 'La situación es requerida';
            }
            if (empty($intervencion)) {
                $errors[] = 'La intervención es requerida';
            }
            if (empty($conclusiones)) {
                $errors[] = 'Las conclusiones son requeridas';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=consejeria&a=crearFicha&id=' . $consejeria_id);
                exit();
            }
            
            // Crear ficha
            $ficha = new FichaConsejeria();
            $ficha->consejeria_id = $consejeria_id;
            $ficha->situacion = $situacion;
            $ficha->intervencion = $intervencion;
            $ficha->conclusiones = $conclusiones;
            
            if ($ficha->create()) {
                // Marcar consejería como realizada
                $consejeriaModel = new Consejeria();
                $consejeriaModel->marcarRealizada($consejeria_id);
                
                $_SESSION['success'] = 'Ficha de consejería creada correctamente';
                header('Location: index.php?c=consejeria&a=misFichas');
                exit();
            } else {
                $_SESSION['error'] = 'Error al crear la ficha';
                header('Location: index.php?c=consejeria&a=crearFicha&id=' . $consejeria_id);
                exit();
            }
        }
    }

    public function misFichas() {
        AuthController::checkRole(['consejero']);
        
        $consejero_id = $this->getConsejeroId();
        
        if (!$consejero_id) {
            $_SESSION['error'] = 'No se encontró perfil de consejero';
            header('Location: index.php?c=consejeria&a=dashboard');
            exit();
        }
        
        $fichaModel = new FichaConsejeria();
        $fichas = $fichaModel->getByConsejero($consejero_id);
        
        require_once 'views/consejeria/mis_fichas.php';
    }

    public function verFicha() {
        AuthController::checkAuth();
        
        $id = $_GET['id'];
        
        $fichaModel = new FichaConsejeria();
        $ficha = $fichaModel->getById($id);
        
        if (!$ficha) {
            $_SESSION['error'] = 'Ficha no encontrada';
            header('Location: index.php');
            exit();
        }
        
        require_once 'views/consejeria/ver_ficha.php';
    }

    // ==========================================
    // CANCELAR CONSEJERÍA (ESTUDIANTE)
    // ==========================================
    
    public function cancelar() {
        AuthController::checkRole(['estudiante']);
        
        $id = $_GET['id'];
        $estudiante_id = $this->getEstudianteId();
        
        $consejeriaModel = new Consejeria();
        
        if ($consejeriaModel->cancelar($id, $estudiante_id)) {
            $_SESSION['success'] = 'Consejería cancelada correctamente';
        } else {
            $_SESSION['error'] = 'No se pudo cancelar la consejería';
        }
        
        header('Location: index.php?c=consejeria&a=misConsejerias');
        exit();
    }
}
