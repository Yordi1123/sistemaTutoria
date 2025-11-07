<?php
/**
 * Script de diagnóstico para problemas de enrutamiento
 */

echo "<h1>Diagnóstico del Sistema</h1>";

echo "<h2>1. Información del Servidor</h2>";
echo "<pre>";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "SAPI: " . php_sapi_name() . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "\n";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "Request Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . "\n";
echo "</pre>";

echo "<h2>2. Verificación de mod_rewrite</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p style='color: green;'>✓ mod_rewrite está habilitado</p>";
    } else {
        echo "<p style='color: red;'>✗ mod_rewrite NO está habilitado</p>";
        echo "<p>Necesitas habilitarlo en httpd.conf</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ No se puede verificar mod_rewrite (función apache_get_modules no disponible)</p>";
}

echo "<h2>3. Verificación de archivos</h2>";
$files = [
    'index.php' => __DIR__ . '/index.php',
    '.htaccess' => __DIR__ . '/.htaccess',
    'config.php' => dirname(__DIR__) . '/app/config/config.php',
    '.env' => dirname(__DIR__) . '/.env',
];

foreach ($files as $name => $path) {
    if (file_exists($path)) {
        echo "<p style='color: green;'>✓ {$name} existe</p>";
        if ($name === '.htaccess') {
            echo "<pre>" . htmlspecialchars(file_get_contents($path)) . "</pre>";
        }
    } else {
        echo "<p style='color: red;'>✗ {$name} NO existe en: {$path}</p>";
    }
}

echo "<h2>4. Prueba de carga de configuración</h2>";
try {
    require_once dirname(__DIR__) . '/app/config/config.php';
    echo "<p style='color: green;'>✓ Configuración cargada correctamente</p>";
    echo "<pre>";
    echo "APP_PATH: " . (defined('APP_PATH') ? APP_PATH : 'NO DEFINIDA') . "\n";
    echo "APP_URL: " . (defined('APP_URL') ? APP_URL : 'NO DEFINIDA') . "\n";
    echo "</pre>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error al cargar configuración: " . $e->getMessage() . "</p>";
}

echo "<h2>5. Prueba de Router</h2>";
try {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    require_once dirname(__DIR__) . '/app/config/config.php';
    require_once dirname(__DIR__) . '/app/helpers/functions.php';
    
    use App\Core\Router;
    $router = new Router();
    echo "<p style='color: green;'>✓ Router cargado correctamente</p>";
    
    // Simular una URI
    $_SERVER['REQUEST_URI'] = '/sistemaAcademico/public/login';
    echo "<p>URI simulada: " . $_SERVER['REQUEST_URI'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error al cargar Router: " . $e->getMessage() . "</p>";
}

echo "<h2>6. Enlaces de prueba</h2>";
echo "<ul>";
echo "<li><a href='test.php'>test.php - Prueba básica de PHP</a></li>";
echo "<li><a href='index.php'>index.php - Acceso directo</a></li>";
echo "<li><a href='index.php?r=login'>index.php?r=login - Con parámetro</a></li>";
echo "</ul>";

echo "<h2>7. Instrucciones</h2>";
echo "<ol>";
echo "<li>Si mod_rewrite NO está habilitado, habilítalo en httpd.conf y reinicia Apache</li>";
echo "<li>Si accedes directamente a index.php y funciona, el problema es mod_rewrite</li>";
echo "<li>Verifica que la URL sea: http://localhost/sistemaAcademico/public/</li>";
echo "<li>Verifica que AllowOverride esté en 'All' en httpd.conf</li>";
echo "</ol>";

