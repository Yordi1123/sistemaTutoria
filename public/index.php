<?php
/**
 * Front Controller - Punto de entrada único de la aplicación
 */

// Cargar configuración
require_once dirname(__DIR__) . '/app/config/config.php';

// Cargar autoloader de Composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Cargar helpers
require_once APP_PATH . 'helpers/functions.php';

// Cargar el router y definir las rutas
use App\Core\Router;

$router = new Router();

// Definir rutas
$router->get('/', 'HomeController', 'index');

// Rutas de Productos
$router->get('/productos', 'ProductoController', 'index');
$router->get('/productos/create', 'ProductoController', 'create');
$router->post('/productos', 'ProductoController', 'store');
$router->get('/productos/{id}', 'ProductoController', 'show');
$router->get('/productos/{id}/edit', 'ProductoController', 'edit');
$router->post('/productos/{id}', 'ProductoController', 'update');
$router->get('/productos/{id}/delete', 'ProductoController', 'delete');

// Rutas de Usuarios
$router->get('/usuarios', 'UsuarioController', 'index');
$router->get('/usuarios/create', 'UsuarioController', 'create');
$router->post('/usuarios', 'UsuarioController', 'store');
$router->get('/usuarios/{id}', 'UsuarioController', 'show');
$router->get('/usuarios/{id}/edit', 'UsuarioController', 'edit');
$router->post('/usuarios/{id}', 'UsuarioController', 'update');
$router->get('/usuarios/{id}/delete', 'UsuarioController', 'delete');

// Resolver la ruta
$router->resolve();
