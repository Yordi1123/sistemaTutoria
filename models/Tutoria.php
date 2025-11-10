<?php
require_once 'models/Database.php';

class Tutoria {
    private $conn;
    private $table = 'tutorias';
    
    public $id;
    public $estudiante_id;
    public $docente_id;
    public $fecha;
    public $hora;
    public $motivo;
    public $estado;
    public $observaciones;
    public $asistencia_confirmada;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR Y SOLICITAR TUTORÍA
    // ==========================================
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (estudiante_id, docente_id, fecha, hora, motivo, estado) 
                  VALUES (:estudiante_id, :docente_id, :fecha, :hora, :motivo, 'pendiente')";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estudiante_id', $this->estudiante_id);
        $stmt->bindParam(':docente_id', $this->docente_id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':hora', $this->hora);
        $stmt->bindParam(':motivo', $this->motivo);
        
        return $stmt->execute();
    }

    // ==========================================
    // VERIFICAR CONFLICTOS DE HORARIO
    // ==========================================
    
    public function verificarConflicto($docente_id, $fecha, $hora) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND fecha = :fecha 
                  AND hora = :hora 
                  AND estado IN ('pendiente', 'confirmada', 'realizada')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // ==========================================
    // OBTENER TUTORÍAS
    // ==========================================
    
    // Obtener todas las tutorías de un estudiante
    public function getByEstudiante($estudiante_id) {
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         d.especialidad as tutor_especialidad,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  WHERE t.estudiante_id = :estudiante_id
                  ORDER BY t.fecha DESC, t.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener tutorías de un docente
    public function getByDocente($docente_id) {
        $query = "SELECT t.*, 
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         e.ciclo as estudiante_ciclo
                  FROM " . $this->table . " t
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  WHERE t.docente_id = :docente_id
                  ORDER BY t.fecha DESC, t.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener tutoría por ID
    public function getById($id) {
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         d.especialidad as tutor_especialidad,
                         d.email as tutor_email,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  WHERE t.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // TUTORÍAS DEL DÍA
    // ==========================================
    
    public function getTutoriasHoy($estudiante_id) {
        $hoy = date('Y-m-d');
        
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         d.especialidad as tutor_especialidad
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE t.estudiante_id = :estudiante_id
                  AND t.fecha = :fecha
                  AND t.estado IN ('confirmada', 'pendiente')
                  ORDER BY t.hora ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->bindParam(':fecha', $hoy);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Próximas tutorías (futuras)
    public function getProximas($estudiante_id, $limit = 5) {
        $hoy = date('Y-m-d');
        
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         d.especialidad as tutor_especialidad
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE t.estudiante_id = :estudiante_id
                  AND t.fecha >= :fecha
                  AND t.estado IN ('confirmada', 'pendiente')
                  ORDER BY t.fecha ASC, t.hora ASC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->bindParam(':fecha', $hoy);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // ACTUALIZAR ESTADO
    // ==========================================
    
    public function updateEstado($id, $estado) {
        $query = "UPDATE " . $this->table . " 
                  SET estado = :estado 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Confirmar asistencia
    public function confirmarAsistencia($id) {
        $query = "UPDATE " . $this->table . " 
                  SET asistencia_confirmada = 1,
                      estado = 'realizada'
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Cancelar tutoría
    public function cancelar($id, $estudiante_id) {
        // Verificar que la tutoría pertenece al estudiante
        $query = "UPDATE " . $this->table . " 
                  SET estado = 'cancelada' 
                  WHERE id = :id 
                  AND estudiante_id = :estudiante_id
                  AND estado = 'pendiente'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        
        return $stmt->execute();
    }

    // ==========================================
    // ESTADÍSTICAS
    // ==========================================
    
    public function getEstadisticas($estudiante_id) {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
                    SUM(CASE WHEN estado = 'realizada' THEN 1 ELSE 0 END) as realizadas,
                    SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas
                  FROM " . $this->table . "
                  WHERE estudiante_id = :estudiante_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // HISTORIAL CON FILTROS
    // ==========================================
    
    public function getHistorial($estudiante_id, $filtro_estado = null) {
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         d.especialidad as tutor_especialidad
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE t.estudiante_id = :estudiante_id";
        
        if ($filtro_estado) {
            $query .= " AND t.estado = :estado";
        }
        
        $query .= " ORDER BY t.fecha DESC, t.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        
        if ($filtro_estado) {
            $stmt->bindParam(':estado', $filtro_estado);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // OBTENER TODAS (ADMIN)
    // ==========================================
    
    public function getAll() {
        $query = "SELECT t.*, 
                         d.nombres as tutor_nombres, 
                         d.apellidos as tutor_apellidos,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " t
                  INNER JOIN docentes d ON t.docente_id = d.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  ORDER BY t.fecha DESC, t.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

