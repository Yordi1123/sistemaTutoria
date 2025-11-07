<?php
/**
 * Bootstrap de la aplicación
 */

// Cargar configuración
require_once dirname(__DIR__) . '/app/config/config.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar autoloader de Composer
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Cargar helpers
require_once APP_PATH . 'Helpers/functions.php';

// Crear el router
$router = new App\Core\Router();

// Cargar rutas
require_once dirname(__DIR__) . '/routes/web.php';

return $router;

