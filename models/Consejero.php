<?php
require_once 'models/Database.php';

class Consejero {
    private $conn;
    private $table = 'consejeros';
    
    public $id;
    public $usuario_id;
    public $codigo;
    public $nombres;
    public $apellidos;
    public $email;
    public $especialidad;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Obtener todos los consejeros
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY apellidos ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener por usuario_id
    public function getByUsuarioId($usuario_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear consejero
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (usuario_id, codigo, nombres, apellidos, email, especialidad) 
                  VALUES (:usuario_id, :codigo, :nombres, :apellidos, :email, :especialidad)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':especialidad', $this->especialidad);
        
        return $stmt->execute();
    }

    // Actualizar consejero
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET codigo = :codigo, nombres = :nombres, apellidos = :apellidos, 
                      email = :email, especialidad = :especialidad 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':especialidad', $this->especialidad);
        
        return $stmt->execute();
    }

    // Eliminar consejero
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
