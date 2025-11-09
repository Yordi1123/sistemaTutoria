<?php
require_once 'models/Usuario.php';

class AuthController {
    
    // Mostrar formulario de login
    public function login() {
        // Si ya está logueado, redirigir a su dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['rol']);
        }
        
        require_once 'views/auth/login.php';
    }

    // Procesar login
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $usuarioModel = new Usuario();
            $user = $usuarioModel->login($username, $password);
            
            if ($user) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rol'] = $user['rol'];
                
                // Redirigir según el rol
                $this->redirectToDashboard($user['rol']);
            } else {
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
                header('Location: index.php?c=auth&a=login');
                exit();
            }
        }
    }

    // Mostrar formulario de registro
    public function register() {
        // Si ya está logueado, redirigir a su dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['rol']);
        }
        
        require_once 'views/auth/register.php';
    }

    // Procesar registro
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $rol = $_POST['rol'];
            
            // Validaciones
            $errors = [];
            
            if (empty($username)) {
                $errors[] = 'El usuario es requerido';
            }
            
            if (empty($password)) {
                $errors[] = 'La contraseña es requerida';
            }
            
            if ($password !== $password_confirm) {
                $errors[] = 'Las contraseñas no coinciden';
            }
            
            if (strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            // Verificar si el usuario ya existe
            $usuarioModel = new Usuario();
            if ($usuarioModel->usernameExists($username)) {
                $errors[] = 'El usuario ya existe';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=auth&a=register');
                exit();
            }
            
            // Crear usuario
            $usuario = new Usuario();
            $usuario->username = $username;
            $usuario->password = $password;
            $usuario->rol = $rol;
            
            if ($usuario->create()) {
                // Obtener el usuario recién creado
                $user = $usuarioModel->getByUsername($username);
                
                // Iniciar sesión automáticamente
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['success'] = 'Registro exitoso. Bienvenido!';
                
                // Redirigir según el rol
                $this->redirectToDashboard($user['rol']);
            } else {
                $_SESSION['error'] = 'Error al registrar usuario';
                header('Location: index.php?c=auth&a=register');
                exit();
            }
        }
    }

    // Cerrar sesión
    public function logout() {
        // Destruir sesión
        session_destroy();
        
        // Iniciar nueva sesión para el mensaje
        session_start();
        $_SESSION['success'] = 'Sesión cerrada correctamente';
        
        header('Location: index.php');
        exit();
    }

    // Redirigir según el rol del usuario
    private function redirectToDashboard($rol) {
        switch ($rol) {
            case 'coordinador':
                header('Location: index.php?c=dashboard&a=admin');
                break;
            case 'docente':
                header('Location: index.php?c=dashboard&a=docente');
                break;
            case 'estudiante':
                header('Location: index.php?c=dashboard&a=estudiante');
                break;
            default:
                header('Location: index.php');
                break;
        }
        exit();
    }

    // Verificar si el usuario está autenticado
    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?c=auth&a=login');
            exit();
        }
    }

    // Verificar si el usuario tiene un rol específico
    public static function checkRole($roles = []) {
        self::checkAuth();
        
        if (!in_array($_SESSION['rol'], $roles)) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            header('Location: index.php');
            exit();
        }
    }
}

