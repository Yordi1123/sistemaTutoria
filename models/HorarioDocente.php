<?php
require_once 'models/Database.php';

class HorarioDocente {
    private $conn;
    private $table = 'horarios_docente';
    
    public $id;
    public $docente_id;
    public $dia_semana;
    public $hora_inicio;
    public $hora_fin;
    public $estado;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR HORARIO
    // ==========================================
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (docente_id, dia_semana, hora_inicio, hora_fin, estado) 
                  VALUES (:docente_id, :dia_semana, :hora_inicio, :hora_fin, :estado)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':docente_id', $this->docente_id);
        $stmt->bindParam(':dia_semana', $this->dia_semana);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_fin', $this->hora_fin);
        $stmt->bindParam(':estado', $this->estado);
        
        return $stmt->execute();
    }

    // ==========================================
    // OBTENER HORARIOS
    // ==========================================
    
    // Obtener todos los horarios de un docente
    public function getByDocente($docente_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  ORDER BY 
                    FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'),
                    hora_inicio ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener horarios activos de un docente
    public function getActivosByDocente($docente_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND estado = 'activo'
                  ORDER BY 
                    FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'),
                    hora_inicio ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener horario por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener horarios por día
    public function getByDocenteYDia($docente_id, $dia_semana) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND dia_semana = :dia_semana
                  AND estado = 'activo'
                  ORDER BY hora_inicio ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->bindParam(':dia_semana', $dia_semana);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // ACTUALIZAR HORARIO
    // ==========================================
    
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET dia_semana = :dia_semana,
                      hora_inicio = :hora_inicio,
                      hora_fin = :hora_fin,
                      estado = :estado
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':dia_semana', $this->dia_semana);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_fin', $this->hora_fin);
        $stmt->bindParam(':estado', $this->estado);
        
        return $stmt->execute();
    }

    // Cambiar estado de un horario
    public function cambiarEstado($id, $estado) {
        $query = "UPDATE " . $this->table . " 
                  SET estado = :estado 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':estado', $estado);
        
        return $stmt->execute();
    }

    // ==========================================
    // ELIMINAR HORARIO
    // ==========================================
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // ==========================================
    // VALIDACIONES
    // ==========================================
    
    // Verificar si existe conflicto de horarios
    public function existeConflicto($docente_id, $dia_semana, $hora_inicio, $hora_fin, $id_excluir = null) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND dia_semana = :dia_semana
                  AND estado = 'activo'
                  AND (
                    (hora_inicio < :hora_fin AND hora_fin > :hora_inicio)
                    OR
                    (hora_inicio >= :hora_inicio AND hora_inicio < :hora_fin)
                    OR
                    (hora_fin > :hora_inicio AND hora_fin <= :hora_fin)
                  )";
        
        if ($id_excluir) {
            $query .= " AND id != :id_excluir";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->bindParam(':dia_semana', $dia_semana);
        $stmt->bindParam(':hora_inicio', $hora_inicio);
        $stmt->bindParam(':hora_fin', $hora_fin);
        
        if ($id_excluir) {
            $stmt->bindParam(':id_excluir', $id_excluir);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] > 0;
    }

    // ==========================================
    // ESTADÍSTICAS
    // ==========================================
    
    // Contar horarios activos de un docente
    public function countActivosByDocente($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND estado = 'activo'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Obtener horarios agrupados por día
    public function getHorariosAgrupados($docente_id) {
        $query = "SELECT dia_semana,
                         GROUP_CONCAT(
                             CONCAT(TIME_FORMAT(hora_inicio, '%H:%i'), ' - ', TIME_FORMAT(hora_fin, '%H:%i'))
                             ORDER BY hora_inicio
                             SEPARATOR ', '
                         ) as horarios
                  FROM " . $this->table . "
                  WHERE docente_id = :docente_id
                  AND estado = 'activo'
                  GROUP BY dia_semana
                  ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar si un docente tiene horarios disponibles
    public function tieneHorariosDisponibles($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE docente_id = :docente_id 
                  AND estado = 'activo'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
}

