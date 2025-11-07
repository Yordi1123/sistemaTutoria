<?php
/**
 * Modelo de Ficha de Tutoria
 */

namespace App\Models;

class Ficha extends Model
{
    protected $table = 'fichas_tutoria';

    /**
     * Obtiene la ficha por ID de tutoría
     */
    public function getByTutoria(int $tutoriaId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE tutoria_id = :tutoria_id";
        return $this->queryOne($sql, ['tutoria_id' => $tutoriaId]);
    }

    /**
     * Crea una nueva ficha
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (tutoria_id, problematica, acciones, conclusiones) 
                VALUES (:tutoria_id, :problematica, :acciones, :conclusiones)";
        return $this->execute($sql, $data);
    }

    /**
     * Actualiza una ficha
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            if ($key !== 'tutoria_id') {
                $fields[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        return $this->execute($sql, $params);
    }
}

