<?php
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

