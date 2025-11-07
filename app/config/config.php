<?php
/**
 * Configuración general del sistema
 */

// Definir constantes de rutas
define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'app' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', ROOT_PATH . 'public' . DIRECTORY_SEPARATOR);
define('STORAGE_PATH', ROOT_PATH . 'storage' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', APP_PATH . 'views' . DIRECTORY_SEPARATOR);

// Configuración de la aplicación
define('APP_NAME', 'Sistema Académico');

// Detectar APP_URL automáticamente
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$scriptDir = str_replace('\\', '/', $scriptDir);
if ($scriptDir !== '/') {
    $scriptDir = rtrim($scriptDir, '/');
}
define('APP_URL', "{$protocol}://{$host}{$scriptDir}");

define('APP_ENV', 'development'); // development, production

// Configuración de errores
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Codificación de caracteres
mb_internal_encoding('UTF-8');

