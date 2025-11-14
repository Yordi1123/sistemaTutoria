<?php
// Verificar que existe el archivo de configuración
if (!file_exists('config.php')) {
    die('
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error de Configuración</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
            .error-box { background: #fee; border: 2px solid #fcc; padding: 20px; border-radius: 5px; }
            h1 { color: #c00; }
            code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; }
            .command { background: #333; color: #0f0; padding: 10px; border-radius: 3px; margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>⚠️ Archivo de Configuración No Encontrado</h1>
            <p>El archivo <code>config.php</code> no existe. Debes crearlo antes de usar el sistema.</p>
            <h2>Pasos para solucionarlo:</h2>
            <ol>
                <li>Copia el archivo de ejemplo:
                    <div class="command">
                        <strong>Windows (PowerShell):</strong><br>
                        Copy-Item config.php.example config.php
                    </div>
                    <div class="command">
                        <strong>Linux/Mac:</strong><br>
                        cp config.php.example config.php
                    </div>
                </li>
                <li>Edita <code>config.php</code> y configura:
                    <ul>
                        <li>Credenciales de base de datos</li>
                        <li>URL base del proyecto</li>
                        <li>Zona horaria</li>
                    </ul>
                </li>
                <li>Recarga esta página</li>
            </ol>
            <p>Para más información, consulta el archivo <code>INSTALACION.md</code></p>
        </div>
    </body>
    </html>
    ');
}

require_once 'config.php';

// Obtener el controlador y acción de la URL
$controller = isset($_GET['c']) ? $_GET['c'] : 'home';
$action = isset($_GET['a']) ? $_GET['a'] : 'index';

// Construir el nombre del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

// Verificar si existe el controlador
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerObj = new $controllerName();
    
    // Verificar si existe el método
    if (method_exists($controllerObj, $action)) {
        $controllerObj->$action();
    } else {
        die("Error: Acción '$action' no encontrada");
    }
} else {
    die("Error: Controlador '$controllerName' no encontrado");
}

