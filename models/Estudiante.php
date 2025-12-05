<?php
require_once 'models/Database.php';

class Estudiante {
    private $conn;
    private $table = 'estudiantes';
    
    public $id;
    public $usuario_id;
    public $codigo;
    public $nombres;
    public $apellidos;
    public $email;
    public $ciclo;
    public $escuela;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Obtener todos los estudiantes
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY apellidos ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener estudiante por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear estudiante (sin usuario por ahora - simplificado)
    public function create() {
        // Por simplicidad, creamos el estudiante sin el usuario_id
        // En una implementación completa, deberías crear primero el usuario
        $query = "INSERT INTO " . $this->table . " 
                  (usuario_id, codigo, nombres, apellidos, email, ciclo, escuela) 
                  VALUES (:usuario_id, :codigo, :nombres, :apellidos, :email, :ciclo, :escuela)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':ciclo', $this->ciclo);
        $stmt->bindParam(':escuela', $this->escuela);
        
        return $stmt->execute();
    }

    // Actualizar estudiante
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET codigo = :codigo, nombres = :nombres, apellidos = :apellidos, 
                    email = :email, ciclo = :ciclo, escuela = :escuela 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':ciclo', $this->ciclo);
        $stmt->bindParam(':escuela', $this->escuela);
        
        return $stmt->execute();
    }

    // Eliminar estudiante
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
