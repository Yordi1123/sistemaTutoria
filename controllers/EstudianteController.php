<?php
require_once 'models/Estudiante.php';
require_once 'controllers/AuthController.php';

class EstudianteController {
    
    // Listar estudiantes - Solo coordinador y docente pueden ver
    public function index() {
        AuthController::checkRole(['coordinador', 'docente']);
        
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        require_once 'views/estudiante/index.php';
    }

    // Mostrar formulario de crear - Solo coordinador
    public function create() {
        AuthController::checkRole(['coordinador']);
        
        require_once 'views/estudiante/form.php';
    }

    // Guardar estudiante - Solo coordinador
    public function save() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/Usuario.php';
            
            $errors = [];
            
            // Obtener y limpiar datos
            $codigo = trim($_POST['codigo'] ?? '');
            $nombres = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $ciclo = $_POST['ciclo'] ?? '';
            $escuela = trim($_POST['escuela'] ?? '');
            
            // Validar campos obligatorios
            if (empty($codigo)) $errors[] = 'El código es obligatorio';
            if (empty($nombres)) $errors[] = 'Los nombres son obligatorios';
            if (empty($apellidos)) $errors[] = 'Los apellidos son obligatorios';
            if (empty($email)) $errors[] = 'El email es obligatorio';
            if (empty($ciclo)) $errors[] = 'El ciclo es obligatorio';
            if (empty($escuela)) $errors[] = 'La escuela es obligatoria';
            
            // Validar formato de email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El formato del email no es válido';
            }
            
            // Validar ciclo numérico entre 1 y 10
            if (!empty($ciclo)) {
                if (!is_numeric($ciclo) || $ciclo < 1 || $ciclo > 10) {
                    $errors[] = 'El ciclo debe ser un número entre 1 y 10';
                }
            }
            
            // Si hay errores, volver al formulario
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=estudiante&a=create');
                exit();
            }
            
            // 1. Crear Usuario
            $usuario = new Usuario();
            $usuario->username = $codigo;
            $usuario->password = $codigo; // Contraseña inicial = código
            $usuario->rol = 'estudiante';
            
            // Verificar si el usuario ya existe
            if ($usuario->usernameExists($codigo)) {
                $_SESSION['error'] = 'El código ya está registrado como usuario';
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=estudiante&a=create');
                exit();
            }
            
            if ($usuario->create()) {
                $usuarioCreado = $usuario->getByUsername($codigo);
                
                // 2. Crear Estudiante
                $estudiante = new Estudiante();
                $estudiante->usuario_id = $usuarioCreado['id'];
                $estudiante->codigo = $codigo;
                $estudiante->nombres = $nombres;
                $estudiante->apellidos = $apellidos;
                $estudiante->email = $email;
                $estudiante->ciclo = (int)$ciclo;
                $estudiante->escuela = $escuela;
                
                if ($estudiante->create()) {
                    $_SESSION['success'] = 'Estudiante registrado correctamente';
                    header('Location: index.php?c=estudiante&a=index');
                    exit();
                } else {
                    $usuario->delete($usuarioCreado['id']);
                    $_SESSION['error'] = 'Error al guardar estudiante';
                    header('Location: index.php?c=estudiante&a=create');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Error al crear usuario';
                header('Location: index.php?c=estudiante&a=create');
                exit();
            }
        }
    }

    // Mostrar formulario de editar - Solo coordinador
    public function edit() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($id);
        require_once 'views/estudiante/form.php';
    }

    // Actualizar estudiante - Solo coordinador
    public function update() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $estudiante = new Estudiante();
            $estudiante->id = $_POST['id'];
            $estudiante->codigo = $_POST['codigo'];
            $estudiante->nombres = $_POST['nombres'];
            $estudiante->apellidos = $_POST['apellidos'];
            $estudiante->email = $_POST['email'];
            $estudiante->ciclo = $_POST['ciclo'];
            $estudiante->escuela = $_POST['escuela'];
            
            if ($estudiante->update()) {
                $_SESSION['success'] = 'Estudiante actualizado correctamente';
                header('Location: index.php?c=estudiante&a=index');
                exit();
            } else {
                $_SESSION['error'] = 'Error al actualizar';
                header('Location: index.php?c=estudiante&a=edit&id=' . $_POST['id']);
                exit();
            }
        }
    }

    // Eliminar estudiante - Solo coordinador
    public function delete() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        $estudiante = new Estudiante();
        if ($estudiante->delete($id)) {
            $_SESSION['success'] = 'Estudiante eliminado correctamente';
            header('Location: index.php?c=estudiante&a=index');
            exit();
        } else {
            $_SESSION['error'] = 'Error al eliminar';
            header('Location: index.php?c=estudiante&a=index');
            exit();
        }
    }
}
