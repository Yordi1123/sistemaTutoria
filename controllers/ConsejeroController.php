<?php
require_once 'controllers/AuthController.php';
require_once 'models/Consejero.php';
require_once 'models/Database.php';

class ConsejeroController {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Listar todos los consejeros
    public function index() {
        AuthController::checkRole(['coordinador']);
        
        $consejeroModel = new Consejero();
        $consejeros = $consejeroModel->getAll();
        
        require_once 'views/consejero/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        AuthController::checkRole(['coordinador']);
        
        $consejero = null;
        $action = 'crear';
        
        require_once 'views/consejero/form.php';
    }

    // Guardar nuevo consejero
    public function store() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo = trim($_POST['codigo']);
            $nombres = trim($_POST['nombres']);
            $apellidos = trim($_POST['apellidos']);
            $email = trim($_POST['email']);
            $especialidad = trim($_POST['especialidad']);
            $password = $_POST['password'];
            
            // Validaciones
            $errors = [];
            
            if (empty($codigo)) {
                $errors[] = 'El código es requerido';
            }
            if (empty($nombres)) {
                $errors[] = 'El nombre es requerido';
            }
            if (empty($apellidos)) {
                $errors[] = 'Los apellidos son requeridos';
            }
            if (empty($password)) {
                $errors[] = 'La contraseña es requerida';
            }
            
            // Verificar si el código ya existe
            $query = "SELECT COUNT(*) as total FROM consejeros WHERE codigo = :codigo";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                $errors[] = 'El código ya está registrado';
            }
            
            // Verificar si username ya existe
            $query = "SELECT COUNT(*) as total FROM usuarios WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $codigo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                $errors[] = 'El usuario ya existe';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=consejero&a=create');
                exit();
            }
            
            try {
                $this->conn->beginTransaction();
                
                // Crear usuario
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO usuarios (username, password, rol) VALUES (:username, :password, 'consejero')";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $codigo);
                $stmt->bindParam(':password', $password_hash);
                $stmt->execute();
                
                $usuario_id = $this->conn->lastInsertId();
                
                // Crear consejero
                $query = "INSERT INTO consejeros (usuario_id, codigo, nombres, apellidos, email, especialidad) 
                          VALUES (:usuario_id, :codigo, :nombres, :apellidos, :email, :especialidad)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':usuario_id', $usuario_id);
                $stmt->bindParam(':codigo', $codigo);
                $stmt->bindParam(':nombres', $nombres);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':especialidad', $especialidad);
                $stmt->execute();
                
                $this->conn->commit();
                
                $_SESSION['success'] = 'Consejero registrado correctamente';
                header('Location: index.php?c=consejero');
                exit();
                
            } catch (Exception $e) {
                $this->conn->rollBack();
                $_SESSION['error'] = 'Error al registrar consejero: ' . $e->getMessage();
                header('Location: index.php?c=consejero&a=create');
                exit();
            }
        }
    }

    // Mostrar formulario de edición
    public function edit() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getById($id);
        
        if (!$consejero) {
            $_SESSION['error'] = 'Consejero no encontrado';
            header('Location: index.php?c=consejero');
            exit();
        }
        
        $action = 'editar';
        
        require_once 'views/consejero/form.php';
    }

    // Actualizar consejero
    public function update() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $codigo = trim($_POST['codigo']);
            $nombres = trim($_POST['nombres']);
            $apellidos = trim($_POST['apellidos']);
            $email = trim($_POST['email']);
            $especialidad = trim($_POST['especialidad']);
            
            // Validaciones
            $errors = [];
            
            if (empty($codigo)) {
                $errors[] = 'El código es requerido';
            }
            if (empty($nombres)) {
                $errors[] = 'El nombre es requerido';
            }
            if (empty($apellidos)) {
                $errors[] = 'Los apellidos son requeridos';
            }
            
            // Verificar si el código ya existe para otro consejero
            $query = "SELECT COUNT(*) as total FROM consejeros WHERE codigo = :codigo AND id != :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                $errors[] = 'El código ya está registrado para otro consejero';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=consejero&a=edit&id=' . $id);
                exit();
            }
            
            // Actualizar consejero
            $consejeroModel = new Consejero();
            $consejeroModel->id = $id;
            $consejeroModel->codigo = $codigo;
            $consejeroModel->nombres = $nombres;
            $consejeroModel->apellidos = $apellidos;
            $consejeroModel->email = $email;
            $consejeroModel->especialidad = $especialidad;
            
            if ($consejeroModel->update()) {
                $_SESSION['success'] = 'Consejero actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar consejero';
            }
            
            header('Location: index.php?c=consejero');
            exit();
        }
    }

    // Eliminar consejero
    public function delete() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        
        // Obtener consejero para eliminar usuario asociado
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getById($id);
        
        if (!$consejero) {
            $_SESSION['error'] = 'Consejero no encontrado';
            header('Location: index.php?c=consejero');
            exit();
        }
        
        try {
            // Eliminar usuario (CASCADE eliminará consejero)
            $query = "DELETE FROM usuarios WHERE id = :usuario_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $consejero['usuario_id']);
            $stmt->execute();
            
            $_SESSION['success'] = 'Consejero eliminado correctamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar consejero. Puede tener consejerías asociadas.';
        }
        
        header('Location: index.php?c=consejero');
        exit();
    }
}
