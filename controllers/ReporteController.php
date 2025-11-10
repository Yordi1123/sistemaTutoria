<?php
require_once 'controllers/AuthController.php';
require_once 'models/Tutor.php';
require_once 'models/Tutoria.php';
require_once 'models/FichaTutoria.php';
require_once 'models/Seguimiento.php';
require_once 'models/Estudiante.php';

class ReporteController {
    
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
    // REPORTE GENERAL DEL DOCENTE
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        // Obtener información del docente
        $tutorModel = new Tutor();
        $docente = $tutorModel->getById($docente_id);
        
        // Obtener estadísticas generales
        $tutoriaModel = new Tutoria();
        $fichaModel = new FichaTutoria();
        $seguimientoModel = new Seguimiento();
        
        $estadisticas = [
            'tutorias' => $tutoriaModel->getEstadisticasDocente($docente_id),
            'fichas' => $fichaModel->countByDocente($docente_id),
            'seguimientos' => $seguimientoModel->countByDocente($docente_id),
            'estudiantes_unicos' => $tutoriaModel->countEstudiantesUnicos($docente_id),
            'seguimientos_atencion' => $seguimientoModel->countRequierenAtencion($docente_id)
        ];
        
        require_once 'views/reporte/index.php';
    }

    // ==========================================
    // REPORTE POR ESTUDIANTE
    // ==========================================
    
    public function estudiante() {
        AuthController::checkAuth();
        
        $estudiante_id = $_GET['id'];
        
        // Obtener información del estudiante
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($estudiante_id);
        
        if (!$estudiante) {
            $_SESSION['error'] = 'Estudiante no encontrado';
            header('Location: index.php?c=reporte&a=index');
            exit();
        }
        
        // Obtener todos los datos del estudiante
        $tutoriaModel = new Tutoria();
        $fichaModel = new FichaTutoria();
        $seguimientoModel = new Seguimiento();
        
        $tutorias = $tutoriaModel->getByEstudiante($estudiante_id);
        $fichas = $fichaModel->getByEstudiante($estudiante_id);
        $seguimientos = $seguimientoModel->getByEstudiante($estudiante_id);
        $evolucion = $seguimientoModel->getEvolucion($estudiante_id);
        $estadisticas_est = $tutoriaModel->getEstadisticas($estudiante_id);
        
        require_once 'views/reporte/estudiante.php';
    }

    // ==========================================
    // REPORTE MENSUAL/PERIODO
    // ==========================================
    
    public function periodo() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        // Filtros
        $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
        $anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');
        
        // Obtener datos del periodo
        $tutoriaModel = new Tutoria();
        $fichaModel = new FichaTutoria();
        $seguimientoModel = new Seguimiento();
        
        $conn = (new Database())->connect();
        
        // Tutorías del periodo
        $query_tutorias = "SELECT t.*, 
                                  e.nombres as estudiante_nombres,
                                  e.apellidos as estudiante_apellidos,
                                  e.codigo as estudiante_codigo
                           FROM tutorias t
                           INNER JOIN estudiantes e ON t.estudiante_id = e.id
                           WHERE t.docente_id = :docente_id
                           AND MONTH(t.fecha) = :mes
                           AND YEAR(t.fecha) = :anio
                           ORDER BY t.fecha DESC";
        
        $stmt = $conn->prepare($query_tutorias);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':anio', $anio);
        $stmt->execute();
        $tutorias_periodo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Seguimientos del periodo
        $query_seguimientos = "SELECT s.*, 
                                      e.nombres as estudiante_nombres,
                                      e.apellidos as estudiante_apellidos,
                                      e.codigo as estudiante_codigo
                               FROM seguimientos s
                               INNER JOIN estudiantes e ON s.estudiante_id = e.id
                               WHERE s.docente_id = :docente_id
                               AND MONTH(s.fecha) = :mes
                               AND YEAR(s.fecha) = :anio
                               ORDER BY s.fecha DESC";
        
        $stmt = $conn->prepare($query_seguimientos);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':anio', $anio);
        $stmt->execute();
        $seguimientos_periodo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Estadísticas del periodo
        $estadisticas_periodo = [
            'tutorias_total' => count($tutorias_periodo),
            'tutorias_realizadas' => count(array_filter($tutorias_periodo, fn($t) => $t['estado'] == 'realizada')),
            'seguimientos_total' => count($seguimientos_periodo),
            'estudiantes_unicos' => count(array_unique(array_column($tutorias_periodo, 'estudiante_id')))
        ];
        
        require_once 'views/reporte/periodo.php';
    }

    // ==========================================
    // REPORTE GENERAL (TODOS LOS DATOS)
    // ==========================================
    
    public function general() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        // Obtener todos los datos
        $tutoriaModel = new Tutoria();
        $fichaModel = new FichaTutoria();
        $seguimientoModel = new Seguimiento();
        
        $tutorias = $tutoriaModel->getProximasDocente($docente_id, 1000); // Todas
        $fichas = $fichaModel->getByDocente($docente_id);
        $seguimientos = $seguimientoModel->getByDocente($docente_id);
        $estadisticas = $tutoriaModel->getEstadisticasDocente($docente_id);
        
        // Agrupar por mes
        $tutorias_por_mes = [];
        foreach ($tutorias as $t) {
            $mes_anio = date('Y-m', strtotime($t['fecha']));
            if (!isset($tutorias_por_mes[$mes_anio])) {
                $tutorias_por_mes[$mes_anio] = 0;
            }
            $tutorias_por_mes[$mes_anio]++;
        }
        
        require_once 'views/reporte/general.php';
    }
}

