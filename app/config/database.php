<?php
/**
 * Configuración de la base de datos
 * Lee las variables desde .env
 */

// Función para leer variables de entorno (ya debería estar definida en config.php)
if (!function_exists('env')) {
    function env($key, $default = null) {
        $envFile = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env';
        
        if (!file_exists($envFile)) {
            return $default;
        }
        
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Separar key y value
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                // Remover comillas si existen
                $value = trim($value, '"\'');
                
                if ($name === $key) {
                    return $value;
                }
            }
        }
        
        return $default;
    }
}

return [
    'host' => env('DB_HOST', 'localhost'),
    'dbname' => env('DB_DATABASE', 'sistema_tutoria'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
