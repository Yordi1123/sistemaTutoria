<?php
/**
 * Clase para manejar la conexión a la base de datos
 * Implementa patrón Singleton
 */

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $config = require APP_PATH . 'config/database.php';

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            
            $this->connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Obtiene la instancia única de la conexión
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtiene la conexión PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Previene la clonación de la instancia
     */
    private function __clone() {}

    /**
     * Previene la deserialización de la instancia
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}

