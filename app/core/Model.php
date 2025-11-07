<?php
/**
 * Clase base para todos los modelos
 */

namespace App\Core;

use App\Core\Database;
use PDO;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Ejecuta una consulta y retorna todos los resultados
     */
    protected function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Ejecuta una consulta y retorna un solo resultado
     */
    protected function queryOne($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Ejecuta una consulta (INSERT, UPDATE, DELETE)
     */
    protected function execute($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Obtiene todos los registros de la tabla
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql);
    }

    /**
     * Busca un registro por ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->queryOne($sql, ['id' => $id]);
    }

    /**
     * Obtiene la última ID insertada
     */
    protected function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}

