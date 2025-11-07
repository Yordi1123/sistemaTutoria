<?php
/**
 * Controlador de Autenticación
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function login()
    {
        // Si ya está autenticado, redirigir al dashboard según su rol
        if (isset($_SESSION['usuario'])) {
            $rol = $_SESSION['usuario']['rol'];
            switch ($rol) {
                case 'estudiante':
                    $this->redirect('/estudiante/dashboard');
                    break;
                case 'docente':
                    $this->redirect('/tutor/dashboard');
                    break;
                case 'coordinador':
                    $this->redirect('/coordinador/dashboard');
                    break;
                default:
                    $this->redirect('/');
            }
            return;
        }

        $this->render('auth/login');
    }

    /**
     * Procesa el login
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        $username = $this->post('username');
        $password = $this->post('password');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Por favor, complete todos los campos';
            $this->redirect('/login');
            return;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->findBy('username', $username);

        if ($usuario && password_verify($password, $usuario['password'])) {
            if ($usuario['estado'] === 'inactivo') {
                $_SESSION['error'] = 'Su cuenta está inactiva';
                $this->redirect('/login');
                return;
            }

            $_SESSION['usuario'] = $usuario;
            $_SESSION['success'] = 'Bienvenido al sistema';

            // Redirigir según el rol
            switch ($usuario['rol']) {
                case 'estudiante':
                    $this->redirect('/estudiante/dashboard');
                    break;
                case 'docente':
                    $this->redirect('/tutor/dashboard');
                    break;
                case 'coordinador':
                    $this->redirect('/coordinador/dashboard');
                    break;
                default:
                    $this->redirect('/');
            }
        } else {
            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            $this->redirect('/login');
        }
    }

    /**
     * Cierra la sesión
     */
    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}

