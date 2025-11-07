<?php
/**
 * Sistema de enrutamiento simple
 */

namespace App\Core;

class Router
{
    private $routes = [];
    private $params = [];

    /**
     * Agrega una ruta
     */
    public function addRoute(string $method, string $path, $controller, string $action = null): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * Agrega una ruta GET
     */
    public function get(string $path, $controller, string $action = null): void
    {
        $this->addRoute('GET', $path, $controller, $action);
    }

    /**
     * Agrega una ruta POST
     */
    public function post(string $path, string $controller, string $action): void
    {
        $this->addRoute('POST', $path, $controller, $action);
    }

    /**
     * Agrega una ruta PUT
     */
    public function put(string $path, string $controller, string $action): void
    {
        $this->addRoute('PUT', $path, $controller, $action);
    }

    /**
     * Agrega una ruta DELETE
     */
    public function delete(string $path, string $controller, string $action): void
    {
        $this->addRoute('DELETE', $path, $controller, $action);
    }

    /**
     * Resuelve la ruta actual
     */
    public function resolve(): void
    {
        // Soporte para métodos PUT y DELETE mediante campo hidden
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        $uri = $this->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($route['path'], $uri)) {
                $this->dispatch($route['controller'], $route['action']);
                return;
            }
        }

        // Si no se encuentra la ruta, mostrar 404
        $this->notFound();
    }

    /**
     * Compara una ruta con la URI actual
     */
    private function matchRoute(string $route, string $uri): bool
    {
        // Convertir la ruta a expresión regular
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches)) {
            // Extraer parámetros de la ruta
            preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $route, $paramNames);
            
            if (!empty($paramNames[1])) {
                $this->params = [];
                foreach ($paramNames[1] as $index => $name) {
                    $this->params[$name] = $matches[$index + 1];
                }
            } else {
                $this->params = [];
            }
            return true;
        }

        return false;
    }

    /**
     * Despacha el controlador y acción
     */
    private function dispatch($controller, string $action = null): void
    {
        // Si es un callback (closure), ejecutarlo directamente
        if (is_callable($controller)) {
            call_user_func($controller);
            return;
        }

        $controllerClass = "App\\Controllers\\{$controller}";
        
        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $controllerInstance = new $controllerClass();
        
        if ($action && !method_exists($controllerInstance, $action)) {
            $this->notFound();
            return;
        }

        // Si no hay acción, intentar usar index
        if (!$action) {
            $action = 'index';
        }

        // Pasar parámetros al método si existen
        $reflection = new \ReflectionMethod($controllerInstance, $action);
        $parameters = $reflection->getParameters();
        
        $args = [];
        foreach ($parameters as $param) {
            $paramName = $param->getName();
            
            // Si es un parámetro de la ruta, pasar el valor
            if (isset($this->params[$paramName])) {
                $args[] = $this->params[$paramName];
            }
            // Si tiene valor por defecto, usar ese
            elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            }
            // Si no, null
            else {
                $args[] = null;
            }
        }
        
        call_user_func_array([$controllerInstance, $action], $args);
    }

    /**
     * Obtiene la URI actual
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remover query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        // Normalizar barras para Windows/Unix
        $uri = str_replace('\\', '/', $uri);
        
        // Obtener el directorio del script (public)
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        $scriptDir = str_replace('\\', '/', $scriptDir);
        
        // Si la URI contiene el directorio del script, removerlo
        if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }

        // Asegurar que empiece con /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        return $uri;
    }

    /**
     * Maneja el error 404
     */
    private function notFound(): void
    {
        http_response_code(404);
        $controller = new \App\Controllers\HomeController();
        if (method_exists($controller, 'notFound')) {
            $controller->notFound();
        } else {
            echo "404 - Página no encontrada";
        }
        exit;
    }

    /**
     * Obtiene los parámetros de la ruta
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
