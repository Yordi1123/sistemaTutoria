<?php
/**
 * Front Controller - Punto de entrada único de la aplicación
 */

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración
require_once dirname(__DIR__) . '/app/config/config.php';

// Cargar autoloader de Composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Cargar helpers
require_once APP_PATH . 'helpers/functions.php';

// Cargar el router y definir las rutas
use App\Core\Router;

$router = new Router();

// Rutas de autenticación
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'authenticate');
$router->get('/logout', 'AuthController', 'logout');

// Rutas de estudiante
$router->get('/estudiante/dashboard', 'EstudianteController', 'dashboard');
$router->get('/estudiante/solicitar', 'EstudianteController', 'solicitar');
$router->post('/estudiante/solicitar', 'EstudianteController', 'storeSolicitud');
$router->get('/estudiante/mis-tutorias', 'EstudianteController', 'misTutorias');

// Rutas de tutor (docente)
$router->get('/tutor/dashboard', 'TutorController', 'dashboard');
$router->get('/tutor/solicitudes', 'TutorController', 'solicitudes');
$router->get('/tutor/solicitudes/{id}/aceptar', 'TutorController', 'aceptarSolicitud');
$router->get('/tutor/solicitudes/{id}/rechazar', 'TutorController', 'rechazarSolicitud');
$router->get('/tutor/tutorias', 'TutorController', 'tutorias');
$router->get('/tutor/ficha/{tutoriaId}', 'TutorController', 'ficha');
$router->post('/tutor/ficha/{tutoriaId}', 'TutorController', 'guardarFicha');

// Rutas de coordinador
$router->get('/coordinador/dashboard', 'CoordinadorController', 'dashboard');
$router->get('/coordinador/tutores', 'CoordinadorController', 'tutores');
$router->get('/coordinador/estudiantes', 'CoordinadorController', 'estudiantes');
$router->get('/coordinador/reportes', 'CoordinadorController', 'reportes');

// Ruta raíz - redirigir según autenticación
$router->get('/', function() {
    if (isset($_SESSION['usuario'])) {
        $rol = $_SESSION['usuario']['rol'];
        switch ($rol) {
            case 'estudiante':
                header('Location: /estudiante/dashboard');
                break;
            case 'docente':
                header('Location: /tutor/dashboard');
                break;
            case 'coordinador':
                header('Location: /coordinador/dashboard');
                break;
            default:
                header('Location: /login');
        }
    } else {
        header('Location: /login');
    }
    exit;
});

// Resolver la ruta
$router->resolve();
