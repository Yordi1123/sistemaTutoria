# Guía de Instalación - Sistema de Tutoría

## Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor Apache con mod_rewrite habilitado
- Laragon, XAMPP, WAMP o similar

## Pasos de Instalación

### 1. Preparar la Base de Datos

1. Abre phpMyAdmin o tu cliente MySQL favorito
2. Importa el archivo `sistema_tutoria.sql`
3. Verifica que la base de datos `sistema_tutoria` se haya creado correctamente

```sql
-- Verifica las tablas creadas
SHOW TABLES FROM sistema_tutoria;
```

### 2. Configurar la Aplicación

**⚠️ IMPORTANTE:** El archivo `config.php` no está incluido en el repositorio por seguridad. Debes crearlo manualmente.

1. Copia el archivo de ejemplo:
   ```bash
   # En Windows (PowerShell)
   Copy-Item config.php.example config.php
   
   # En Linux/Mac
   cp config.php.example config.php
   ```

2. Abre el archivo `config.php` y ajusta los parámetros según tu entorno:

```php
// Configuración de la base de datos
define('DB_HOST', '');     // Servidor de BD
define('DB_NAME', 'sistema_tutoria'); // Nombre de la BD
define('DB_USER', '');          // Usuario de BD
define('DB_PASS', '');              // Contraseña de BD

// Configuración de la aplicación
define('BASE_URL', 'http://localhost/sistemaTutoria/');
```

**Importante:** 
- Si tu carpeta del proyecto tiene un nombre diferente, ajusta la `BASE_URL` en consecuencia.
- Si tu servidor MySQL usa otro puerto, agrégalo al DB_HOST (ej: `localhost:3307`)
- Ajusta la zona horaria según tu región en la línea `date_default_timezone_set()`

### 3. Verificar mod_rewrite de Apache

Para Laragon:
- mod_rewrite viene habilitado por defecto

Para XAMPP:
1. Abre `httpd.conf`
2. Busca y descomenta (quita el #):
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
3. Reinicia Apache

### 4. Permisos (solo Linux/Mac)

```bash
chmod -R 755 /ruta/a/sistemaTutoria
chmod 777 /ruta/a/sistemaTutoria/tmp  # Si existe carpeta temporal
```

### 5. Probar la Instalación

Abre tu navegador y accede a:

```
http://localhost/sistemaTutoria/
```

Deberías ver la página de inicio del sistema.

## 🔑 Credenciales de Acceso

El archivo `CREDENCIALES.txt` contiene las credenciales de los usuarios de prueba. Este archivo no está incluido en el repositorio por seguridad.

Si necesitas las credenciales, copia el archivo de ejemplo:
```bash
# En Windows (PowerShell)
Copy-Item CREDENCIALES.txt.example CREDENCIALES.txt

# En Linux/Mac
cp CREDENCIALES.txt.example CREDENCIALES.txt
```

**⚠️ IMPORTANTE:** Si no puedes iniciar sesión después de clonar el repositorio, ejecuta el script `scripts_bd/actualizar_passwords.sql` en phpMyAdmin para restablecer las contraseñas.

## 🧪 Datos de Prueba

La base de datos incluye datos de prueba:

### Estudiantes
- **Carlos Ramirez Santos**
  - Código: 0201910001
  - Email: cramirez@uns.edu.pe
  - Ciclo: 6

- **Ana Maria Torres Diaz**
  - Código: 0201910002
  - Email: atorres@uns.edu.pe
  - Ciclo: 5

### Docentes/Tutores
- **Juan Carlos Perez Rodriguez**
  - Código: DOC001
  - Especialidad: Sistemas

- **Maria Elena Garcia Lopez**
  - Código: DOC002
  - Especialidad: Base de Datos

## 📍 URLs Principales

| Página | URL |
|--------|-----|
| Inicio | `http://localhost/sistemaTutoria/` |
| Estudiantes | `http://localhost/sistemaTutoria/index.php?c=estudiante` |
| Nuevo Estudiante | `http://localhost/sistemaTutoria/index.php?c=estudiante&a=create` |
| Tutores | `http://localhost/sistemaTutoria/index.php?c=tutor` |
| Nuevo Tutor | `http://localhost/sistemaTutoria/index.php?c=tutor&a=create` |

## ⚠️ Solución de Problemas

### Error: "Archivo de Configuración No Encontrado"
✅ Copia `config.php.example` a `config.php`
✅ Edita `config.php` con tus credenciales
✅ Verifica que el archivo tenga permisos de lectura

### Error: "No se puede conectar a la base de datos"
✅ Verifica que MySQL esté corriendo
✅ Verifica las credenciales en `config.php`
✅ Verifica que la base de datos exista
✅ Verifica que el puerto de MySQL sea el correcto (por defecto 3306)

### Error: "Página no encontrada" o "Error 404"
✅ Verifica que mod_rewrite esté habilitado
✅ Verifica la BASE_URL en `config.php`
✅ Verifica que el archivo `.htaccess` exista

### Error: "No hay estudiantes registrados"
✅ Verifica que importaste correctamente el archivo SQL
✅ Verifica la conexión a la base de datos
✅ Revisa las tablas en phpMyAdmin

### Los estilos no cargan
✅ Verifica la BASE_URL en `config.php`
✅ Verifica que la carpeta `assets/` exista con sus subcarpetas
✅ Verifica que Apache tenga acceso a la carpeta

## 🔧 Configuración Avanzada

### Cambiar Zona Horaria

Edita `config.php`:

```php
date_default_timezone_set('America/Lima');  // Cambia según tu región
```

### Aumentar Límite de Subida de Archivos

Edita `.htaccess`:

```apache
php_value upload_max_filesize 20M
php_value post_max_size 20M
```

## 📞 Soporte

Si encuentras algún problema, verifica:
1. Los logs de PHP en tu servidor
2. Los logs de Apache
3. La consola del navegador (F12)

## ✅ Verificación de Instalación Correcta

Checklist:
- [ ] La base de datos está creada e importada
- [ ] El archivo config.php está configurado correctamente
- [ ] Apache está corriendo
- [ ] MySQL está corriendo
- [ ] Puedes acceder a la página de inicio
- [ ] Puedes ver la lista de estudiantes
- [ ] Puedes ver la lista de tutores
- [ ] Los estilos CSS se cargan correctamente
- [ ] Los enlaces del menú funcionan

¡Listo! Tu sistema está funcionando correctamente.

