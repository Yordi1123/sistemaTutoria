<?php
/**
 * Modelo de Tutoria
 */

namespace App\Models;

class Tutoria extends Model
{
    protected $table = 'tutorias';

    /**
     * Obtiene tutorías por estudiante
     */
    public function getByEstudiante(int $estudianteId): array
    {
        $sql = "SELECT t.*, 
                e.nombres as estudiante_nombres, e.apellidos as estudiante_apellidos,
                d.nombres as docente_nombres, d.apellidos as docente_apellidos
                FROM {$this->table} t
                INNER JOIN estudiantes est ON t.estudiante_id = est.id
                INNER JOIN estudiantes e ON t.estudiante_id = e.id
                INNER JOIN docentes d ON t.docente_id = d.id
                WHERE t.estudiante_id = (SELECT id FROM estudiantes WHERE usuario_id = :estudiante_id)
                ORDER BY t.fecha DESC, t.hora DESC";
        return $this->query($sql, ['estudiante_id' => $estudianteId]);
    }

    /**
     * Obtiene tutorías por docente
     */
    public function getByDocente(int $docenteUsuarioId, string $estado = null): array
    {
        $sql = "SELECT t.*, 
                e.nombres as estudiante_nombres, e.apellidos as estudiante_apellidos,
                d.nombres as docente_nombres, d.apellidos as docente_apellidos
                FROM {$this->table} t
                INNER JOIN estudiantes e ON t.estudiante_id = e.id
                INNER JOIN docentes d ON t.docente_id = d.id
                WHERE d.usuario_id = :docente_usuario_id";
        
        $params = ['docente_usuario_id' => $docenteUsuarioId];
        
        if ($estado) {
            $sql .= " AND t.estado = :estado";
            $params['estado'] = $estado;
        }
        
        $sql .= " ORDER BY t.fecha DESC, t.hora DESC";
        
        return $this->query($sql, $params);
    }

    /**
     * Cuenta tutorías por estado
     */
    public function countByEstado(string $estado, int $docenteUsuarioId = null): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} t";
        $params = ['estado' => $estado];
        
        if ($docenteUsuarioId) {
            $sql .= " INNER JOIN docentes d ON t.docente_id = d.id WHERE d.usuario_id = :docente_usuario_id AND t.estado = :estado";
            $params['docente_usuario_id'] = $docenteUsuarioId;
        } else {
            $sql .= " WHERE t.estado = :estado";
        }
        
        $result = $this->queryOne($sql, $params);
        return (int) $result['total'];
    }

    /**
     * Cuenta todas las tutorías
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->queryOne($sql);
        return (int) $result['total'];
    }

    /**
     * Obtiene estadísticas por estado
     */
    public function getStatsByEstado(): array
    {
        $sql = "SELECT estado, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY estado";
        return $this->query($sql);
    }

    /**
     * Obtiene estadísticas por mes
     */
    public function getStatsByMonth(): array
    {
        $sql = "SELECT DATE_FORMAT(fecha, '%Y-%m') as mes, COUNT(*) as total 
                FROM {$this->table} 
                GROUP BY DATE_FORMAT(fecha, '%Y-%m')
                ORDER BY mes DESC
                LIMIT 12";
        return $this->query($sql);
    }

    /**
     * Crea una nueva tutoría
     */
    public function create(array $data): bool
    {
        // Obtener el estudiante_id real desde el usuario_id si viene como usuario_id
        if (isset($data['estudiante_id'])) {
            $sql = "SELECT id FROM estudiantes WHERE usuario_id = :usuario_id";
            $estudiante = $this->queryOne($sql, ['usuario_id' => $data['estudiante_id']]);
            if ($estudiante) {
                $data['estudiante_id'] = $estudiante['id'];
            } else {
                // Si no se encuentra, asumir que ya viene el estudiante_id correcto
                // o lanzar un error
                return false;
            }
        }

        // Validar que docente_id existe (puede venir como usuario_id o como docente_id)
        // Por ahora asumimos que viene como docente_id de la tabla docentes
        $sql = "INSERT INTO {$this->table} (estudiante_id, docente_id, fecha, hora, motivo, estado) 
                VALUES (:estudiante_id, :docente_id, :fecha, :hora, :motivo, :estado)";
        return $this->execute($sql, $data);
    }

    /**
     * Actualiza una tutoría
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        return $this->execute($sql, $params);
    }
}

