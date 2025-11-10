# Documentación Técnica - Sistema de Tutoría MVC

## 📊 Resumen del Proyecto

| Aspecto | Detalle |
|---------|---------|
| **Patrón de Diseño** | MVC (Modelo-Vista-Controlador) |
| **Lenguajes** | PHP, HTML, CSS, JavaScript |
| **Base de Datos** | MySQL con PDO |
| **Framework** | Ninguno (PHP Puro) |
| **Librerías Externas** | Ninguna |
| **Total de Archivos** | 22 archivos |
| **Líneas de Código** | ~500 líneas (aprox.) |

## 🏗️ Arquitectura del Sistema

### Flujo de Peticiones

```
Usuario → index.php → Controlador → Modelo → Base de Datos
                         ↓
                      Vista → Usuario
```

### 1. index.php (Front Controller)
Es el punto de entrada único de la aplicación.

**Funcionamiento:**
```php
1. Recibe parámetros: ?c=controlador&a=accion&id=valor
2. Construye el nombre del controlador
3. Verifica que el archivo exista
4. Instancia el controlador
5. Ejecuta la acción solicitada
```

**Ejemplo de URL:**
```
index.php?c=estudiante&a=edit&id=3

c = estudiante  → EstudianteController
a = edit        → método edit()
id = 3          → parámetro para el método
```

### 2. Controladores (Controllers)

**Ubicación:** `/controllers/`

**Responsabilidades:**
- Recibir y procesar peticiones
- Validar datos de entrada
- Coordinar modelos y vistas
- Redirigir flujos

**Convención de nombres:**
- Archivo: `NombreController.php`
- Clase: `class NombreController { }`
- Métodos: `public function accion() { }`

**Métodos estándar CRUD:**
```php
index()   → Listar registros
create()  → Mostrar formulario de creación
save()    → Guardar nuevo registro
edit()    → Mostrar formulario de edición
update()  → Actualizar registro
delete()  → Eliminar registro
```

### 3. Modelos (Models)

**Ubicación:** `/models/`

**Responsabilidades:**
- Interactuar con la base de datos
- Ejecutar consultas SQL
- Validar datos de negocio
- Retornar resultados

**Convención de nombres:**
- Archivo: `Nombre.php`
- Clase: `class Nombre { }`
- Tabla: `nombres` (plural)

**Métodos estándar:**
```php
getAll()      → SELECT * FROM tabla
getById($id)  → SELECT * WHERE id = ?
create()      → INSERT INTO tabla
update()      → UPDATE tabla SET ...
delete($id)   → DELETE FROM tabla WHERE id = ?
```

**Seguridad:**
- Uso de PDO con prepared statements
- Prevención de SQL Injection
- Binding de parámetros

### 4. Vistas (Views)

**Ubicación:** `/views/`

**Estructura:**
```
views/
├── layout/
│   ├── header.php    → Encabezado común
│   └── footer.php    → Pie de página común
├── modulo/
│   ├── index.php     → Lista
│   └── form.php      → Formulario (crear/editar)
```

**Responsabilidades:**
- Presentar información al usuario
- Recibir entrada de datos
- Incluir layout común
- Escapar HTML (XSS prevention)

**Buenas prácticas:**
```php
// Siempre escapar datos
<?php echo htmlspecialchars($variable); ?>

// Verificar existencia de variables
<?php if (isset($variable)): ?>
    <!-- código -->
<?php endif; ?>

// Incluir layout
<?php require_once 'views/layout/header.php'; ?>
```

## 🔒 Seguridad

### 1. SQL Injection Prevention
```php
// MAL ❌
$query = "SELECT * FROM tabla WHERE id = " . $_GET['id'];

// BIEN ✅
$query = "SELECT * FROM tabla WHERE id = :id";
$stmt->bindParam(':id', $id);
```

### 2. XSS Prevention
```php
// MAL ❌
<td><?php echo $dato; ?></td>

// BIEN ✅
<td><?php echo htmlspecialchars($dato); ?></td>
```

### 3. CSRF Protection
Para implementar (no incluido en versión básica):
```php
// Generar token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Validar en formularios
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Token inválido');
}
```

### 4. Protección de Archivos Sensibles
```apache
# En .htaccess
<FilesMatch "^(config\.php)">
    Order Deny,Allow
    Deny from all
</FilesMatch>
```

## 🗄️ Base de Datos

### Estructura Principal

**Tabla: estudiantes**
```sql
- id (PK, AUTO_INCREMENT)
- usuario_id (FK → usuarios)
- codigo (UNIQUE)
- nombres
- apellidos
- email
- ciclo
- escuela
```

**Tabla: docentes**
```sql
- id (PK, AUTO_INCREMENT)
- usuario_id (FK → usuarios)
- codigo (UNIQUE)
- nombres
- apellidos
- email
- especialidad
```

### Relaciones
```
usuarios (1) → (N) estudiantes
usuarios (1) → (N) docentes
estudiantes (N) → (N) docentes (tutorías)
```

## 📝 Convenciones de Código

### Nomenclatura

**PHP:**
- Clases: `PascalCase`
- Métodos: `camelCase`
- Variables: `$snake_case`
- Constantes: `UPPER_CASE`

**Base de Datos:**
- Tablas: `plural_snake_case`
- Columnas: `snake_case`

**Archivos:**
- Controladores: `PascalCaseController.php`
- Modelos: `PascalCase.php`
- Vistas: `snake_case.php`

### Estructura de Archivos

**Controlador:**
```php
<?php
require_once 'models/Modelo.php';

class MiController {
    public function index() {
        // Lógica
        require_once 'views/mi/index.php';
    }
}
```

**Modelo:**
```php
<?php
require_once 'models/Database.php';

class MiModelo {
    private $conn;
    private $table = 'tabla';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
}
```

**Vista:**
```php
<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <!-- Contenido -->
</div>

<?php require_once 'views/layout/footer.php'; ?>
```

## 🎨 Frontend

### CSS
- **Archivo:** `assets/css/style.css`
- **Metodología:** CSS Vanilla
- **Responsive:** Mobile-first con media queries
- **Grid System:** CSS Grid para cards

### JavaScript
- **Archivo:** `assets/js/main.js`
- **Vanilla JS** (sin jQuery ni librerías)
- **Event Listeners:** DOMContentLoaded
- **Validaciones:** Client-side básicas

### Componentes UI

**Botones:**
```css
.btn              → Botón estándar (azul)
.btn-primary      → Botón primario (verde)
.btn-danger       → Botón peligro (rojo)
.btn-small        → Botón pequeño
```

**Formularios:**
```html
<form class="form">
    <div class="form-group">
        <label>Etiqueta</label>
        <input type="text">
    </div>
    <div class="form-actions">
        <button class="btn">Guardar</button>
    </div>
</form>
```

## 🔧 Extensión del Sistema

### Agregar un Nuevo Módulo

**1. Crear el Modelo** (`models/NuevoModulo.php`)
```php
<?php
require_once 'models/Database.php';

class NuevoModulo {
    private $conn;
    private $table = 'tabla_modulo';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    public function getAll() { /* ... */ }
    public function getById($id) { /* ... */ }
    public function create() { /* ... */ }
    public function update() { /* ... */ }
    public function delete($id) { /* ... */ }
}
```

**2. Crear el Controlador** (`controllers/NuevoModuloController.php`)
```php
<?php
require_once 'models/NuevoModulo.php';

class NuevoModuloController {
    public function index() {
        $modelo = new NuevoModulo();
        $datos = $modelo->getAll();
        require_once 'views/nuevomodulo/index.php';
    }
    
    // Más métodos CRUD...
}
```

**3. Crear las Vistas** (`views/nuevomodulo/`)
- `index.php` - Lista de registros
- `form.php` - Formulario crear/editar

**4. Agregar al Menú** (`views/layout/header.php`)
```php
<li><a href="<?php echo BASE_URL; ?>index.php?c=nuevomodulo">Nuevo Módulo</a></li>
```

## 📊 Métricas del Código

| Componente | Archivos | Líneas |
|------------|----------|--------|
| Configuración | 3 | ~100 |
| Modelos | 3 | ~150 |
| Controladores | 3 | ~150 |
| Vistas | 9 | ~200 |
| Assets | 2 | ~150 |
| **Total** | **22** | **~750** |

## 🚀 Optimizaciones Futuras

1. **Implementar Router:** Sistema de URLs amigables
2. **Autoload:** PSR-4 autoloading de clases
3. **Validación:** Clase Validator para formularios
4. **Sesiones:** Sistema de autenticación completo
5. **API REST:** Endpoints JSON para AJAX
6. **Caché:** Sistema de caché de consultas
7. **Logs:** Sistema de registro de errores
8. **Tests:** PHPUnit para pruebas unitarias

## 📚 Referencias

- [PHP Manual](https://www.php.net/manual/es/)
- [PDO Documentation](https://www.php.net/manual/es/book.pdo.php)
- [MVC Pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)

---

**Versión:** 1.0  
**Fecha:** Noviembre 2025  
**Autor:** Sistema de Tutoría UNS

