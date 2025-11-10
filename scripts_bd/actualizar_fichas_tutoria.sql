-- =====================================================
-- ACTUALIZACIÓN: Fichas de Tutoría
-- Agregar campo "recomendaciones" a la tabla fichas_tutoria
-- =====================================================

USE sistema_tutoria;

-- Verificar si la columna ya existe antes de agregarla
-- (esto evita errores si el script se ejecuta múltiples veces)

SET @dbname = 'sistema_tutoria';
SET @tablename = 'fichas_tutoria';
SET @columnname = 'recomendaciones';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      TABLE_SCHEMA = @dbname
      AND TABLE_NAME = @tablename
      AND COLUMN_NAME = @columnname
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' TEXT AFTER conclusiones')
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- =====================================================
-- VERIFICACIÓN
-- =====================================================
-- Para verificar que el campo se agregó correctamente, ejecuta:
-- DESCRIBE fichas_tutoria;
-- 
-- Deberías ver:
-- +-------------------+---------+------+-----+-------------------+-------+
-- | Field             | Type    | Null | Key | Default           | Extra |
-- +-------------------+---------+------+-----+-------------------+-------+
-- | id                | int     | NO   | PRI | NULL              | auto_increment |
-- | tutoria_id        | int     | NO   | MUL | NULL              |       |
-- | problematica      | text    | YES  |     | NULL              |       |
-- | acciones          | text    | YES  |     | NULL              |       |
-- | conclusiones      | text    | YES  |     | NULL              |       |
-- | recomendaciones   | text    | YES  |     | NULL              |       |
-- | fecha_registro    | timestamp| NO  |     | CURRENT_TIMESTAMP |       |
-- +-------------------+---------+------+-----+-------------------+-------+
-- =====================================================

SELECT '✓ Actualización completada - Campo recomendaciones agregado a fichas_tutoria' as Resultado;

