-- =====================================================
-- ACTUALIZAR CONTRASEÑAS DE USUARIOS EXISTENTES
-- =====================================================
-- Ejecuta este script para corregir las contraseñas
-- de los usuarios de prueba
-- =====================================================

USE sistema_tutoria;

-- Actualizar contraseña del administrador (admin123)
UPDATE usuarios 
SET password = '$2y$10$eFdKUnR0Kv1XW28C/PflKOsgGsXPLIZGz62XuXPfn/G.QDJNFih/.' 
WHERE username = 'admin';

-- Actualizar contraseñas de docentes (doc123)
UPDATE usuarios 
SET password = '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS' 
WHERE username IN ('DOC001', 'DOC002');

-- Actualizar contraseña de consejero (cons123)
UPDATE usuarios 
SET password = '$2y$10$2Ew/hCeDTACgVxtXIciOmeUcK/2lPRG9wThVNzrSHXIZQ0F5H4i4O' 
WHERE username = 'CONS001';

-- Actualizar contraseñas de estudiantes (est123)
UPDATE usuarios 
SET password = '$2y$10$PJAYkwb8yM4XtfnfIZHMAOpmn1.YyYfCvGqEQiUlRRF3IzEuq0uvq' 
WHERE username IN ('0201910001', '0201910002');

-- Verificar que se actualizaron correctamente
SELECT username, rol, 
       CASE 
           WHEN rol = 'coordinador' THEN 'admin123'
           WHEN rol = 'docente' THEN 'doc123'
           WHEN rol = 'consejero' THEN 'cons123'
           WHEN rol = 'estudiante' THEN 'est123'
       END as password_texto
FROM usuarios
ORDER BY id;

-- =====================================================
-- RESULTADO ESPERADO:
-- =====================================================
-- admin         | coordinador | admin123
-- DOC001        | docente     | doc123
-- DOC002        | docente     | doc123
-- CONS001       | consejero   | cons123
-- 0201910001    | estudiante  | est123
-- 0201910002    | estudiante  | est123
-- =====================================================

