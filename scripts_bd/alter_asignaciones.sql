-- ============================================
-- Script: Asignaciones de Tutoría
-- Sistema de Tutoría Universitaria
-- Fecha: 2025-12-16
-- ============================================

-- Tabla para asignaciones permanentes tutor-estudiante
CREATE TABLE IF NOT EXISTS `asignaciones_tutoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estudiante_id` int NOT NULL,
  `docente_id` int NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `motivo_reasignacion` text COLLATE utf8mb4_unicode_ci,
  `fecha_reasignacion` date DEFAULT NULL,
  `docente_anterior_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estudiante` (`estudiante_id`),
  KEY `idx_docente` (`docente_id`),
  KEY `idx_activo` (`activo`),
  CONSTRAINT `asignaciones_estudiante_fk` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignaciones_docente_fk` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índice único para evitar duplicados activos
CREATE UNIQUE INDEX `unique_asignacion_activa` ON `asignaciones_tutoria` (`estudiante_id`, `activo`) 
WHERE `activo` = 1;

-- Nota: MySQL no soporta índices condicionales, usar trigger o validación en aplicación

-- Datos de prueba opcionales
-- INSERT INTO asignaciones_tutoria (estudiante_id, docente_id, fecha_asignacion, activo) VALUES
-- (1, 1, CURDATE(), 1),
-- (2, 2, CURDATE(), 1);
