-- =====================================================
-- ACTUALIZACIÓN BASE DE DATOS PARA MÓDULO DE TUTORÍAS
-- =====================================================

USE sistema_tutoria;

-- Agregar campo asistencia_confirmada a tabla tutorias
ALTER TABLE tutorias 
ADD COLUMN asistencia_confirmada BOOLEAN DEFAULT FALSE AFTER observaciones;

-- Verificar la estructura actualizada
DESCRIBE tutorias;

-- =====================================================
-- MENSAJE
-- =====================================================
SELECT 'Base de datos actualizada correctamente' as mensaje;

