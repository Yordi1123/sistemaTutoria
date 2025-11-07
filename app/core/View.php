<?php
/**
 * Clase para renderizar vistas
 */

namespace App\Core;

class View
{
    /**
     * Renderiza una vista
     */
    public static function render(string $view, array $data = [], bool $useLayout = true): string
    {
        // Extraer las variables del array $data
        extract($data);

        // Convertir la ruta de vista (home.index -> home/index.php)
        $viewPath = VIEWS_PATH . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("Vista no encontrada: {$viewPath}");
        }

        // Si no se usa layout, solo renderizar la vista
        if (!$useLayout) {
            ob_start();
            include $viewPath;
            return ob_get_clean();
        }

        // Renderizar con layout
        $layoutPath = VIEWS_PATH . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
        if (file_exists($layoutPath)) {
            // Capturar el contenido de la vista
            ob_start();
            include $viewPath;
            $content = ob_get_clean();

            // Incluir el layout con el contenido
            ob_start();
            include $layoutPath;
            return ob_get_clean();
        } else {
            // Si no hay layout, solo mostrar la vista
            ob_start();
            include $viewPath;
            return ob_get_clean();
        }
    }
}

