<?php
/**
 * Manejo de excepciones
 */

namespace App\Exceptions;

use Exception;

class Handler
{
    /**
     * Maneja una excepción
     */
    public function handle(Exception $e): void
    {
        if (defined('APP_ENV') && APP_ENV === 'development') {
            $this->renderException($e);
        } else {
            $this->renderProductionError($e);
        }
    }

    /**
     * Renderiza la excepción en desarrollo
     */
    private function renderException(Exception $e): void
    {
        http_response_code(500);
        
        echo '<!DOCTYPE html>
<html>
<head>
    <title>Error - ' . htmlspecialchars($e->getMessage()) . '</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .error-container { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #e74c3c; }
        .trace { background: #f9f9f9; padding: 10px; border-left: 3px solid #3498db; margin-top: 10px; }
        pre { overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error: ' . htmlspecialchars($e->getMessage()) . '</h1>
        <p><strong>Archivo:</strong> ' . htmlspecialchars($e->getFile()) . '</p>
        <p><strong>Línea:</strong> ' . $e->getLine() . '</p>
        <div class="trace">
            <h3>Stack Trace:</h3>
            <pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>
        </div>
    </div>
</body>
</html>';
        exit;
    }

    /**
     * Renderiza error en producción
     */
    private function renderProductionError(Exception $e): void
    {
        // Log del error
        $logMessage = date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
        $logFile = STORAGE_PATH . 'logs' . DIRECTORY_SEPARATOR . 'error.log';
        if (is_dir(dirname($logFile))) {
            file_put_contents($logFile, $logMessage, FILE_APPEND);
        } else {
            error_log($e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
        }

        http_response_code(500);
        
        if (file_exists(VIEWS_PATH . 'errors/500.php')) {
            include VIEWS_PATH . 'errors/500.php';
        } else {
            echo '<!DOCTYPE html>
<html>
<head>
    <title>Error del Servidor</title>
</head>
<body>
    <h1>Error 500</h1>
    <p>Ha ocurrido un error en el servidor. Por favor, intente más tarde.</p>
</body>
</html>';
        }
        exit;
    }
}

