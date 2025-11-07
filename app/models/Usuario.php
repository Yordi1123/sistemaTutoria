<?php
/**
 * Modelo de Usuario
 */

namespace App\Models;

class Usuario extends Model
{
    protected $table = 'usuarios';

    /**
     * Busca usuarios por rol
     */
    public function getByRol(string $rol): array
    {
        $sql = "SELECT u.*, 
                e.codigo as estudiante_codigo, e.nombres as estudiante_nombres, e.apellidos as estudiante_apellidos,
                d.codigo as docente_codigo, d.nombres as docente_nombres, d.apellidos as docente_apellidos
                FROM {$this->table} u
                LEFT JOIN estudiantes e ON u.id = e.usuario_id
                LEFT JOIN docentes d ON u.id = d.usuario_id
                WHERE u.rol = :rol";
        return $this->query($sql, ['rol' => $rol]);
    }

    /**
     * Cuenta usuarios por rol
     */
    public function countByRol(string $rol): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE rol = :rol";
        $result = $this->queryOne($sql, ['rol' => $rol]);
        return (int) $result['total'];
    }

    /**
     * Obtiene lista de docentes con sus IDs reales
     */
    public function getDocentesList(): array
    {
        $usuariosDocentes = $this->getByRol('docente');
        $docentes = [];
        
        foreach ($usuariosDocentes as $usuario) {
            $sql = "SELECT id, nombres, apellidos FROM docentes WHERE usuario_id = :usuario_id";
            $docente = $this->queryOne($sql, ['usuario_id' => $usuario['id']]);
            if ($docente) {
                $docentes[] = [
                    'id' => $docente['id'],
                    'nombres' => $docente['nombres'],
                    'apellidos' => $docente['apellidos']
                ];
            }
        }
        
        return $docentes;
    }
}

