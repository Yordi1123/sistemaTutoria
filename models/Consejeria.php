<?php
require_once 'models/Database.php';

class Consejeria {
    private $conn;
    private $table = 'consejerias';
    
    public $id;
    public $estudiante_id;
    public $consejero_id;
    public $fecha;
    public $hora;
    public $motivo;
    public $estado;
    public $observaciones;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR CONSEJERÍA
    // ==========================================
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (estudiante_id, consejero_id, fecha, hora, motivo, estado) 
                  VALUES (:estudiante_id, :consejero_id, :fecha, :hora, :motivo, 'pendiente')";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estudiante_id', $this->estudiante_id);
        $stmt->bindParam(':consejero_id', $this->consejero_id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':hora', $this->hora);
        $stmt->bindParam(':motivo', $this->motivo);
        
        return $stmt->execute();
    }

    // ==========================================
    // OBTENER CONSEJERÍAS
    // ==========================================
    
    // Obtener todas las consejerías
    public function getAll() {
        $query = "SELECT c.*, 
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         co.nombres as consejero_nombres, 
                         co.apellidos as consejero_apellidos,
                         co.especialidad as consejero_especialidad
                  FROM " . $this->table . " c
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN consejeros co ON c.consejero_id = co.id
                  ORDER BY c.fecha DESC, c.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT c.*, 
                         e.id as estudiante_id,
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         e.email as estudiante_email,
                         e.ciclo as estudiante_ciclo,
                         co.nombres as consejero_nombres, 
                         co.apellidos as consejero_apellidos,
                         co.especialidad as consejero_especialidad,
                         co.email as consejero_email
                  FROM " . $this->table . " c
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN consejeros co ON c.consejero_id = co.id
                  WHERE c.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener por consejero
    public function getByConsejero($consejero_id) {
        $query = "SELECT c.*, 
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         e.ciclo as estudiante_ciclo
                  FROM " . $this->table . " c
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE c.consejero_id = :consejero_id
                  ORDER BY c.fecha DESC, c.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por estudiante
    public function getByEstudiante($estudiante_id) {
        $query = "SELECT c.*, 
                         co.nombres as consejero_nombres, 
                         co.apellidos as consejero_apellidos,
                         co.especialidad as consejero_especialidad
                  FROM " . $this->table . " c
                  INNER JOIN consejeros co ON c.consejero_id = co.id
                  WHERE c.estudiante_id = :estudiante_id
                  ORDER BY c.fecha DESC, c.hora DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // SOLICITUDES PENDIENTES
    // ==========================================
    
    public function getSolicitudesPendientes($consejero_id) {
        $query = "SELECT c.*, 
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         e.ciclo as estudiante_ciclo,
                         e.email as estudiante_email
                  FROM " . $this->table . " c
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE c.consejero_id = :consejero_id
                  AND c.estado = 'pendiente'
                  ORDER BY c.fecha ASC, c.hora ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPendientes($consejero_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE consejero_id = :consejero_id 
                  AND estado = 'pendiente'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // ==========================================
    // ACTUALIZAR ESTADO
    // ==========================================
    
    public function aprobar($id, $observaciones = null) {
        $query = "UPDATE " . $this->table . " 
                  SET estado = 'confirmada',
                      observaciones = :observaciones
                  WHERE id = :id 
                  AND estado = 'pendiente'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':observaciones', $observaciones);
        
        return $stmt->execute();
    }

    public function rechazar($id, $motivo) {
        $observaciones = "Rechazada. Motivo: " . $motivo;
        
        $query = "UPDATE " . $this->table . " 
                  SET estado = 'cancelada',
                      observaciones = :observaciones
                  WHERE id = :id 
                  AND estado = 'pendiente'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':observaciones', $observaciones);
        
        return $stmt->execute();
    }

    public function marcarRealizada($id) {
        $query = "UPDATE " . $this->table . " 
                  SET estado = 'realizada'
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function cancelar($id, $estudiante_id) {
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
    // VERIFICAR CONFLICTOS
    // ==========================================
    
    public function verificarConflicto($consejero_id, $fecha, $hora) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE consejero_id = :consejero_id 
                  AND fecha = :fecha 
                  AND hora = :hora 
                  AND estado IN ('pendiente', 'confirmada')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    public function perteneceAConsejero($id, $consejero_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE id = :id 
                  AND consejero_id = :consejero_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // ==========================================
    // ESTADÍSTICAS
    // ==========================================
    
    public function getEstadisticasConsejero($consejero_id) {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
                    SUM(CASE WHEN estado = 'realizada' THEN 1 ELSE 0 END) as realizadas,
                    SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas
                  FROM " . $this->table . "
                  WHERE consejero_id = :consejero_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getConsejeriasHoy($consejero_id) {
        $hoy = date('Y-m-d');
        
        $query = "SELECT c.*, 
                         e.nombres as estudiante_nombres, 
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " c
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE c.consejero_id = :consejero_id
                  AND c.fecha = :fecha
                  AND c.estado IN ('confirmada', 'pendiente')
                  ORDER BY c.hora ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->bindParam(':fecha', $hoy);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countEstudiantesUnicos($consejero_id) {
        $query = "SELECT COUNT(DISTINCT estudiante_id) as total
                  FROM " . $this->table . "
                  WHERE consejero_id = :consejero_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
