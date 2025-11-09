<?php
require_once 'models/Database.php';

class Usuario {
    private $conn;
    private $table = 'usuarios';
    
    public $id;
    public $username;
    public $password;
    public $rol;
    public $estado;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Obtener usuario por username
    public function getByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (username, password, rol, estado) 
                  VALUES (:username, :password, :rol, 'activo')";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash de la contraseña
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':rol', $this->rol);
        
        return $stmt->execute();
    }

    // Verificar si el username ya existe
    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // Verificar credenciales de login
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE username = :username AND estado = 'activo' 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    // Obtener todos los usuarios
    public function getAll() {
        $query = "SELECT id, username, rol, estado, fecha_creacion 
                  FROM " . $this->table . " 
                  ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar estado del usuario
    public function updateEstado($id, $estado) {
        $query = "UPDATE " . $this->table . " SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar usuario
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

