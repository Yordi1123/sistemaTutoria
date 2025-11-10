-- =====================================================
-- SISTEMA DE TUTORIA - HORARIOS DE DOCENTES
-- Crear tabla para gestión de disponibilidad horaria
-- =====================================================

USE sistema_tutoria;

-- =====================================================
-- TABLA: horarios_docente
-- =====================================================
CREATE TABLE IF NOT EXISTS horarios_docente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    docente_id INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE CASCADE,
    -- Evitar horarios duplicados para el mismo docente en el mismo día
    UNIQUE KEY unique_horario (docente_id, dia_semana, hora_inicio)
) ENGINE=InnoDB;

-- =====================================================
-- ÍNDICES PARA MEJORAR RENDIMIENTO
-- =====================================================
CREATE INDEX idx_docente_estado ON horarios_docente(docente_id, estado);
CREATE INDEX idx_dia_semana ON horarios_docente(dia_semana);

-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================

-- Horarios para DOC001 (Juan Carlos Perez)
INSERT INTO horarios_docente (docente_id, dia_semana, hora_inicio, hora_fin, estado) VALUES
(1, 'Lunes', '08:00:00', '10:00:00', 'activo'),
(1, 'Lunes', '14:00:00', '16:00:00', 'activo'),
(1, 'Miércoles', '08:00:00', '10:00:00', 'activo'),
(1, 'Miércoles', '14:00:00', '16:00:00', 'activo'),
(1, 'Viernes', '10:00:00', '12:00:00', 'activo');

-- Horarios para DOC002 (Maria Elena Garcia)
INSERT INTO horarios_docente (docente_id, dia_semana, hora_inicio, hora_fin, estado) VALUES
(2, 'Martes', '09:00:00', '11:00:00', 'activo'),
(2, 'Martes', '15:00:00', '17:00:00', 'activo'),
(2, 'Jueves', '09:00:00', '11:00:00', 'activo'),
(2, 'Jueves', '15:00:00', '17:00:00', 'activo'),
(2, 'Viernes', '14:00:00', '16:00:00', 'activo');

-- =====================================================
-- VERIFICACIÓN
-- =====================================================
-- Para verificar que la tabla se creó correctamente:
-- DESCRIBE horarios_docente;
-- 
-- Para ver los datos insertados:
-- SELECT * FROM horarios_docente;
-- =====================================================

SELECT '✓ Tabla horarios_docente creada exitosamente' as Resultado;
SELECT COUNT(*) as 'Horarios Insertados' FROM horarios_docente;

