<?php
require_once 'models/Database.php';

class FichaTutoria {
    private $conn;
    private $table = 'fichas_tutoria';
    
    public $id;
    public $tutoria_id;
    public $problematica;
    public $acciones;
    public $conclusiones;
    public $recomendaciones;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ==========================================
    // CREAR FICHA
    // ==========================================
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (tutoria_id, problematica, acciones, conclusiones, recomendaciones) 
                  VALUES (:tutoria_id, :problematica, :acciones, :conclusiones, :recomendaciones)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':tutoria_id', $this->tutoria_id);
        $stmt->bindParam(':problematica', $this->problematica);
        $stmt->bindParam(':acciones', $this->acciones);
        $stmt->bindParam(':conclusiones', $this->conclusiones);
        $stmt->bindParam(':recomendaciones', $this->recomendaciones);
        
        return $stmt->execute();
    }

    // ==========================================
    // OBTENER FICHAS
    // ==========================================
    
    // Obtener ficha por ID de tutoría
    public function getByTutoria($tutoria_id) {
        $query = "SELECT f.*, 
                         t.fecha as tutoria_fecha,
                         t.hora as tutoria_hora,
                         t.motivo as tutoria_motivo,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " f
                  INNER JOIN tutorias t ON f.tutoria_id = t.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE f.tutoria_id = :tutoria_id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutoria_id', $tutoria_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener ficha por ID
    public function getById($id) {
        $query = "SELECT f.*, 
                         t.fecha as tutoria_fecha,
                         t.hora as tutoria_hora,
                         t.motivo as tutoria_motivo,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " f
                  INNER JOIN tutorias t ON f.tutoria_id = t.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE f.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las fichas de un docente
    public function getByDocente($docente_id) {
        $query = "SELECT f.*, 
                         t.fecha as tutoria_fecha,
                         t.hora as tutoria_hora,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " f
                  INNER JOIN tutorias t ON f.tutoria_id = t.id
                  INNER JOIN estudiantes e ON t.estudiante_id = e.id
                  WHERE t.docente_id = :docente_id
                  ORDER BY f.fecha_registro DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar si ya existe una ficha para esta tutoría
    public function existe($tutoria_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE tutoria_id = :tutoria_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutoria_id', $tutoria_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // ==========================================
    // ACTUALIZAR FICHA
    // ==========================================
    
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET problematica = :problematica,
                      acciones = :acciones,
                      conclusiones = :conclusiones,
                      recomendaciones = :recomendaciones
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':problematica', $this->problematica);
        $stmt->bindParam(':acciones', $this->acciones);
        $stmt->bindParam(':conclusiones', $this->conclusiones);
        $stmt->bindParam(':recomendaciones', $this->recomendaciones);
        
        return $stmt->execute();
    }

    // ==========================================
    // ESTADÍSTICAS
    // ==========================================
    
    // Contar fichas de un docente
    public function countByDocente($docente_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " f
                  INNER JOIN tutorias t ON f.tutoria_id = t.id
                  WHERE t.docente_id = :docente_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':docente_id', $docente_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Obtener fichas de un estudiante
    public function getByEstudiante($estudiante_id) {
        $query = "SELECT f.*, 
                         t.fecha as tutoria_fecha,
                         t.hora as tutoria_hora,
                         t.motivo as tutoria_motivo,
                         d.nombres as docente_nombres,
                         d.apellidos as docente_apellidos
                  FROM " . $this->table . " f
                  INNER JOIN tutorias t ON f.tutoria_id = t.id
                  INNER JOIN docentes d ON t.docente_id = d.id
                  WHERE t.estudiante_id = :estudiante_id
                  ORDER BY f.fecha_registro DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

