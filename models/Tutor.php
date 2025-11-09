<?php
require_once 'models/Database.php';

class Tutor {
    private $conn;
    private $table = 'docentes';
    
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

    // Obtener todos los docentes/tutores
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY apellidos ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener docente/tutor por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear docente/tutor (sin usuario por ahora - simplificado)
    public function create() {
        // Por simplicidad, creamos el docente sin el usuario_id
        // En una implementación completa, deberías crear primero el usuario
        $query = "INSERT INTO " . $this->table . " 
                  (usuario_id, codigo, nombres, apellidos, email, especialidad) 
                  VALUES (1, :codigo, :nombres, :apellidos, :email, :especialidad)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombres', $this->nombres);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':especialidad', $this->especialidad);
        
        return $stmt->execute();
    }

    // Actualizar docente/tutor
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

    // Eliminar docente/tutor
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
