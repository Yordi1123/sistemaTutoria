<?php
require_once 'models/Database.php';

class FichaConsejeria {
    private $conn;
    private $table = 'fichas_consejeria';
    
    public $id;
    public $consejeria_id;
    public $situacion;
    public $intervencion;
    public $conclusiones;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear ficha
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (consejeria_id, situacion, intervencion, conclusiones) 
                  VALUES (:consejeria_id, :situacion, :intervencion, :conclusiones)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':consejeria_id', $this->consejeria_id);
        $stmt->bindParam(':situacion', $this->situacion);
        $stmt->bindParam(':intervencion', $this->intervencion);
        $stmt->bindParam(':conclusiones', $this->conclusiones);
        
        return $stmt->execute();
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT f.*, 
                         c.fecha as consejeria_fecha,
                         c.hora as consejeria_hora,
                         c.motivo as consejeria_motivo,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo,
                         co.nombres as consejero_nombres,
                         co.apellidos as consejero_apellidos
                  FROM " . $this->table . " f
                  INNER JOIN consejerias c ON f.consejeria_id = c.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  INNER JOIN consejeros co ON c.consejero_id = co.id
                  WHERE f.id = :id
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener por consejería
    public function getByConsejeria($consejeria_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE consejeria_id = :consejeria_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejeria_id', $consejeria_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar si existe ficha
    public function existe($consejeria_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE consejeria_id = :consejeria_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejeria_id', $consejeria_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // Obtener por consejero
    public function getByConsejero($consejero_id) {
        $query = "SELECT f.*, 
                         c.fecha as consejeria_fecha,
                         c.hora as consejeria_hora,
                         e.nombres as estudiante_nombres,
                         e.apellidos as estudiante_apellidos,
                         e.codigo as estudiante_codigo
                  FROM " . $this->table . " f
                  INNER JOIN consejerias c ON f.consejeria_id = c.id
                  INNER JOIN estudiantes e ON c.estudiante_id = e.id
                  WHERE c.consejero_id = :consejero_id
                  ORDER BY c.fecha DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por estudiante
    public function getByEstudiante($estudiante_id) {
        $query = "SELECT f.*, 
                         c.fecha as consejeria_fecha,
                         c.hora as consejeria_hora,
                         co.nombres as consejero_nombres,
                         co.apellidos as consejero_apellidos,
                         co.especialidad as consejero_especialidad
                  FROM " . $this->table . " f
                  INNER JOIN consejerias c ON f.consejeria_id = c.id
                  INNER JOIN consejeros co ON c.consejero_id = co.id
                  WHERE c.estudiante_id = :estudiante_id
                  ORDER BY c.fecha DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar ficha
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET situacion = :situacion, 
                      intervencion = :intervencion, 
                      conclusiones = :conclusiones
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':situacion', $this->situacion);
        $stmt->bindParam(':intervencion', $this->intervencion);
        $stmt->bindParam(':conclusiones', $this->conclusiones);
        
        return $stmt->execute();
    }

    // Contar fichas por consejero
    public function countByConsejero($consejero_id) {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " f
                  INNER JOIN consejerias c ON f.consejeria_id = c.id
                  WHERE c.consejero_id = :consejero_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
