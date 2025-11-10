<?php
require_once 'models/Database.php';

class Seguimiento {
    private $conn;
    private $table = 'seguimientos';
    
    public $id;
    public $estudiante_id;
    public $docente_id;
    public $fecha;
    public $tipo;
    public $observaciones;
    public $recomendaciones;
    public $estado_animo;
    public $nivel_avance;
    public $requiere_atencion;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR SEGUIMIENTO
    // ==========================================
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (estudiante_id, docente_id, fecha, tipo, observaciones, recomendaciones, 
                   estado_animo, nivel_avance, requiere_atencion) 
                  VALUES (:estudiante_id, :docente_id, :fecha, :tipo, :observaciones, :recomendaciones,
                          :estado_animo, :nivel_avance, :requiere_atencion)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':estudiante_id', $this->estudiante_id);
        $stmt->bindParam(':docente_id', $this->docente_id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':observaciones', $this->observaciones);
        $stmt->bindParam(':recomendaciones', $this->recomendaciones);
        $stmt->bindParam(':estado_animo', $this->estado_animo);
        $stmt->bindParam(':nivel_avance', $this->nivel_avance);
        $stmt->bindParam(':requiere_atencion', $this->requiere_atencion);
        
        return $stmt->execute();
    }

    // ==========================================
    // OBTENER SEGUIMIENTOS
    // ==========================================
    
    // Obtener seguimiento por ID
    public function getById($id) {
        $query = "SELECT s.*, 
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " s
                  INNER JOIN estudiantes e ON s.estudiante_id = e.id
                  INNER JOIN docentes d ON s.docente_id = d.id
                  WHERE s.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener seguimientos de un estudiante
    public function getByEstudiante($estudiante_id, $limit = null) {
        $query = "SELECT s.*, 
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " s
                  INNER JOIN docentes d ON s.docente_id = d.id
                  WHERE s.estudiante_id = :estudiante_id
                  ORDER BY s.fecha DESC";
        
        if ($limit) {
            $query .= " LIMIT " . intval($limit);
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener seguimientos de un docente
    public function getByDocente($docente_id) {
        $query = "SELECT s.*, 
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " s
                  INNER JOIN estudiantes e ON s.estudiante_id = e.id
                  WHERE s.docente_id = :docente_id
                  ORDER BY s.fecha DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener seguimientos que requieren atención
    public function getQueRequierenAtencion($docente_id) {
        $query = "SELECT s.*, 
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " s
                  INNER JOIN estudiantes e ON s.estudiante_id = e.id
                  WHERE s.docente_id = :docente_id
                  AND s.requiere_atencion = TRUE
                  ORDER BY s.fecha DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener último seguimiento de un estudiante
    public function getUltimoByEstudiante($estudiante_id) {
        $query = "SELECT s.*, 
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " s
                  INNER JOIN docentes d ON s.docente_id = d.id
                  WHERE s.estudiante_id = :estudiante_id
                  ORDER BY s.fecha DESC
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // ACTUALIZAR SEGUIMIENTO
    // ==========================================
    
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET fecha = :fecha,
                      tipo = :tipo,
                      observaciones = :observaciones,
                      recomendaciones = :recomendaciones,
                      estado_animo = :estado_animo,
                      nivel_avance = :nivel_avance,
                      requiere_atencion = :requiere_atencion
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':observaciones', $this->observaciones);
        $stmt->bindParam(':recomendaciones', $this->recomendaciones);
        $stmt->bindParam(':estado_animo', $this->estado_animo);
        $stmt->bindParam(':nivel_avance', $this->nivel_avance);
        $stmt->bindParam(':requiere_atencion', $this->requiere_atencion);
        
        return $stmt->execute();
    }

    // ==========================================
    // ELIMINAR SEGUIMIENTO
    // ==========================================
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // ==========================================
    // ESTADÍSTICAS
    // ==========================================
    
    // Contar seguimientos de un docente
    public function countByDocente($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Contar seguimientos que requieren atención
    public function countRequierenAtencion($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id
                  AND requiere_atencion = TRUE";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Obtener estadísticas por tipo
    public function getEstadisticasPorTipo($docente_id) {
        $query = "SELECT tipo, COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id
                  GROUP BY tipo";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener evolución de un estudiante
    public function getEvolucion($estudiante_id) {
        $query = "SELECT fecha, nivel_avance, estado_animo 
                  FROM " . $this->table . " 
                  WHERE estudiante_id = :estudiante_id
                  ORDER BY fecha ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

