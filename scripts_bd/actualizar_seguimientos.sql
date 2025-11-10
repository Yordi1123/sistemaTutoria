-- =====================================================
-- SISTEMA DE TUTORIA - SEGUIMIENTO DE ESTUDIANTES
-- Crear tabla para registrar el seguimiento continuo
-- =====================================================

USE sistema_tutoria;

-- =====================================================
-- TABLA: seguimientos
-- =====================================================
CREATE TABLE IF NOT EXISTS seguimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    docente_id INT NOT NULL,
    fecha DATE NOT NULL,
    tipo ENUM('academico', 'personal', 'conductual', 'general') DEFAULT 'general',
    observaciones TEXT NOT NULL,
    recomendaciones TEXT,
    estado_animo ENUM('muy_bajo', 'bajo', 'normal', 'bueno', 'muy_bueno') DEFAULT 'normal',
    nivel_avance ENUM('deficiente', 'insuficiente', 'satisfactorio', 'destacado') DEFAULT 'satisfactorio',
    requiere_atencion BOOLEAN DEFAULT FALSE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- ÍNDICES PARA MEJORAR RENDIMIENTO
-- =====================================================
CREATE INDEX idx_estudiante ON seguimientos(estudiante_id);
CREATE INDEX idx_docente ON seguimientos(docente_id);
CREATE INDEX idx_fecha ON seguimientos(fecha);
CREATE INDEX idx_requiere_atencion ON seguimientos(requiere_atencion);

-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================

-- Seguimientos para estudiante Carlos Ramirez (estudiante_id = 1)
INSERT INTO seguimientos (estudiante_id, docente_id, fecha, tipo, observaciones, recomendaciones, estado_animo, nivel_avance, requiere_atencion) VALUES
(1, 1, '2024-11-05', 'academico', 'El estudiante muestra interés en mejorar sus calificaciones en el curso de Base de Datos. Ha asistido a todas las tutorías programadas.', 'Continuar con las sesiones semanales y proporcionar ejercicios adicionales.', 'bueno', 'satisfactorio', FALSE),
(1, 1, '2024-10-28', 'personal', 'El estudiante manifestó dificultades para gestionar su tiempo debido a trabajo part-time.', 'Elaborar un horario de estudio flexible y priorizar las actividades académicas más importantes.', 'bajo', 'insuficiente', TRUE);

-- Seguimientos para estudiante Ana Maria Torres (estudiante_id = 2)
INSERT INTO seguimientos (estudiante_id, docente_id, fecha, tipo, observaciones, recomendaciones, estado_animo, nivel_avance, requiere_atencion) VALUES
(2, 2, '2024-11-08', 'academico', 'Excelente desempeño en el curso de Programación. Muestra habilidades destacadas en resolución de problemas.', 'Incentivar a participar en competencias de programación y proyectos de investigación.', 'muy_bueno', 'destacado', FALSE),
(2, 2, '2024-10-30', 'general', 'Primera sesión de seguimiento. Estudiante muestra motivación y compromiso con sus estudios.', 'Mantener el ritmo de estudio actual y explorar áreas de especialización.', 'bueno', 'satisfactorio', FALSE);

-- =====================================================
-- VERIFICACIÓN
-- =====================================================
-- Para verificar que la tabla se creó correctamente:
-- DESCRIBE seguimientos;
-- 
-- Para ver los datos insertados:
-- SELECT * FROM seguimientos ORDER BY fecha DESC;
-- =====================================================

SELECT '✓ Tabla seguimientos creada exitosamente' as Resultado;
SELECT COUNT(*) as 'Seguimientos Insertados' FROM seguimientos;

