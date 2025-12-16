<?php
require_once 'models/Database.php';

class Asignacion {
    private $conn;
    private $table = 'asignaciones_tutoria';
    
    public $id;
    public $estudiante_id;
    public $docente_id;
    public $fecha_asignacion;
    public $activo;
    public $motivo_reasignacion;
    public $fecha_reasignacion;
    public $docente_anterior_id;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR ASIGNACIÓN
    // ==========================================
    
    public function create() {
        // Primero desactivar cualquier asignación previa del estudiante
        $this->desactivarAsignacionesEstudiante($this->estudiante_id);
        
        $query = "INSERT INTO " . $this->table . " 
                  (estudiante_id, docente_id, fecha_asignacion, activo) 
                  VALUES (:estudiante_id, :docente_id, :fecha_asignacion, 1)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estudiante_id', $this->estudiante_id);
        $stmt->bindParam(':docente_id', $this->docente_id);
        $stmt->bindParam(':fecha_asignacion', $this->fecha_asignacion);
        
        return $stmt->execute();
    }

    // ==========================================
    // OBTENER ASIGNACIONES
    // ==========================================
    
    // Todas las asignaciones activas
    public function getAll() {
        $query = "SELECT a.*, 
                         e.codigo as estudiante_codigo,
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.ciclo as estudiante_ciclo,
                         e.email as estudiante_email,
                         d.codigo as docente_codigo,
                         d.nombres as docente_nombres, 
                         d.apellidos as docente_apellidos,
                         d.especialidad as docente_especialidad
                  FROM " . $this->table . " a
                  INNER JOIN estudiantes e ON a.estudiante_id = e.id
                  INNER JOIN docentes d ON a.docente_id = d.id
                  WHERE a.activo = 1
                  ORDER BY e.apellidos ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Asignación por ID
    public function getById($id) {
        $query = "SELECT a.*, 
                         e.codigo as estudiante_codigo,
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.ciclo as estudiante_ciclo,
                         d.codigo as docente_codigo,
                         d.nombres as docente_nombres, 
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " a
                  INNER JOIN estudiantes e ON a.estudiante_id = e.id
                  INNER JOIN docentes d ON a.docente_id = d.id
                  WHERE a.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Estudiantes asignados a un docente
    public function getByDocente($docente_id) {
        $query = "SELECT a.*, 
                         e.id as estudiante_id,
                         e.codigo as estudiante_codigo,
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.ciclo as estudiante_ciclo,
                         e.email as estudiante_email,
                         e.escuela as estudiante_escuela
                  FROM " . $this->table . " a
                  INNER JOIN estudiantes e ON a.estudiante_id = e.id
                  WHERE a.docente_id = :docente_id
                  AND a.activo = 1
                  ORDER BY e.apellidos ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tutor asignado a un estudiante
    public function getByEstudiante($estudiante_id) {
        $query = "SELECT a.*, 
                         d.id as docente_id,
                         d.codigo as docente_codigo,
                         d.nombres as docente_nombres, 
                         d.apellidos as docente_apellidos,
                         d.especialidad as docente_especialidad,
                         d.email as docente_email
                  FROM " . $this->table . " a
                  INNER JOIN docentes d ON a.docente_id = d.id
                  WHERE a.estudiante_id = :estudiante_id
                  AND a.activo = 1
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // REASIGNACIÓN
    // ==========================================
    
    public function reasignar($id, $nuevo_docente_id, $motivo) {
        // Obtener asignación actual
        $asignacion_actual = $this->getById($id);
        
        if (!$asignacion_actual) {
            return false;
        }
        
        $docente_anterior_id = $asignacion_actual['docente_id'];
        $estudiante_id = $asignacion_actual['estudiante_id'];
        $fecha_hoy = date('Y-m-d');
        
        // Actualizar asignación anterior como inactiva
        $query_desactivar = "UPDATE " . $this->table . " 
                             SET activo = 0,
                                 motivo_reasignacion = :motivo,
                                 fecha_reasignacion = :fecha
                             WHERE id = :id";
        
        $stmt = $this->conn->prepare($query_desactivar);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':fecha', $fecha_hoy);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Crear nueva asignación
        $query_nueva = "INSERT INTO " . $this->table . " 
                        (estudiante_id, docente_id, fecha_asignacion, activo, docente_anterior_id) 
                        VALUES (:estudiante_id, :docente_id, :fecha, 1, :docente_anterior_id)";
        
        $stmt = $this->conn->prepare($query_nueva);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->bindParam(':docente_id', $nuevo_docente_id);
        $stmt->bindParam(':fecha', $fecha_hoy);
        $stmt->bindParam(':docente_anterior_id', $docente_anterior_id);
        
        return $stmt->execute();
    }

    // ==========================================
    // HISTORIAL DE REASIGNACIONES
    // ==========================================
    
    public function getHistorialReasignaciones($estudiante_id) {
        $query = "SELECT a.*, 
                         d.nombres as docente_nombres, 
                         d.apellidos as docente_apellidos,
                         da.nombres as docente_anterior_nombres,
                         da.apellidos as docente_anterior_apellidos
                  FROM " . $this->table . " a
                  INNER JOIN docentes d ON a.docente_id = d.id
                  LEFT JOIN docentes da ON a.docente_anterior_id = da.id
                  WHERE a.estudiante_id = :estudiante_id
                  ORDER BY a.fecha_asignacion DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // UTILIDADES
    // ==========================================
    
    // Desactivar asignaciones previas de un estudiante
    private function desactivarAsignacionesEstudiante($estudiante_id) {
        $query = "UPDATE " . $this->table . " 
                  SET activo = 0 
                  WHERE estudiante_id = :estudiante_id 
                  AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        return $stmt->execute();
    }

    // Verificar si estudiante ya tiene asignación activa
    public function tieneAsignacionActiva($estudiante_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE estudiante_id = :estudiante_id 
                  AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // Contar estudiantes asignados a un docente
    public function countByDocente($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Estudiantes sin asignación
    public function getEstudiantesSinAsignacion() {
        $query = "SELECT e.* 
                  FROM estudiantes e
                  LEFT JOIN " . $this->table . " a ON e.id = a.estudiante_id AND a.activo = 1
                  WHERE a.id IS NULL
                  ORDER BY e.apellidos ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar asignación
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
