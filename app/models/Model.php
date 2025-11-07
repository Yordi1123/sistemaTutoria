<?php
/**
 * Clase base para todos los modelos
 */

namespace App\Models;

use App\Models\Database;
use PDO;
use PDOException;

abstract class Model
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
    protected function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ejecuta una consulta y retorna un solo resultado
     */
    protected function queryOne(string $sql, array $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ejecuta una consulta (INSERT, UPDATE, DELETE)
     */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Obtiene todos los registros de la tabla
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql);
    }

    /**
     * Busca un registro por ID
     */
    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->queryOne($sql, ['id' => $id]);
    }

    /**
     * Busca un registro por campo
     */
    public function findBy(string $field, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value";
        return $this->queryOne($sql, ['value' => $value]);
    }

    /**
     * Busca todos los registros por campo
     */
    public function findAllBy(string $field, $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value";
        return $this->query($sql, ['value' => $value]);
    }

    /**
     * Crea un nuevo registro
     */
    public function create(array $data): bool
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        return $this->execute($sql, $data);
    }

    /**
     * Actualiza un registro
     */
    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach (array_keys($data) as $field) {
            $set[] = "{$field} = :{$field}";
        }
        $setString = implode(', ', $set);
        $data['id'] = $id;
        $sql = "UPDATE {$this->table} SET {$setString} WHERE id = :id";
        return $this->execute($sql, $data);
    }

    /**
     * Elimina un registro
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }

    /**
     * Obtiene la última ID insertada
     */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }

    /**
     * Obtiene el número de registros
     */
    public function count(string $conditions = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        if (!empty($conditions)) {
            $sql .= " WHERE {$conditions}";
        }
        $result = $this->queryOne($sql, $params);
        return (int) ($result['count'] ?? 0);
    }
}
