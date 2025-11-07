<?php
/**
 * Funciones helper globales
 */

if (!function_exists('asset')) {
    /**
     * Obtiene la URL de un asset
     */
    function asset(string $path): string
    {
        return APP_URL . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /**
     * Genera URLs
     */
    function url(string $path = ''): string
    {
        return APP_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirige a una URL
     */
    function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}

if (!function_exists('e')) {
    /**
     * Escapa HTML
     */
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die
     */
    function dd(...$vars): void
    {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die();
    }
}

if (!function_exists('old')) {
    /**
     * Obtiene valor anterior de un input
     */
    function old(string $key, $default = null)
    {
        return $_SESSION['_old_input'][$key] ?? $default;
    }
}

if (!function_exists('flash')) {
    /**
     * Mensajes flash
     */
    function flash(string $key, $value = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($value === null) {
            $message = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $message;
        }
        $_SESSION['_flash'][$key] = $value;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Genera un token CSRF
     */
    function csrf_token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Genera un campo hidden con el token CSRF
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}
