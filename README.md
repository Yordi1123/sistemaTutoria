# Sistema de Tutoría - MVC PHP Puro

Sistema web desarrollado con PHP utilizando el patrón Modelo-Vista-Controlador (MVC) sin frameworks externos. Solo PHP, HTML, CSS y JavaScript puros.

## 📁 Estructura del Proyecto

```
sistemaTutoria/
│
├── index.php              # Punto de entrada
├── config.php            # Configuración (BD, constantes)
├── .htaccess            # Configuración Apache
│
├── controllers/         # Controladores
│   ├── HomeController.php
│   ├── EstudianteController.php
│   └── TutorController.php
│
├── models/              # Modelos
│   ├── Database.php
│   ├── Estudiante.php
│   └── Tutor.php
│
├── views/               # Vistas
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── home/
│   │   └── index.php
│   ├── estudiante/
│   │   ├── index.php
│   │   └── form.php
│   └── tutor/
│       ├── index.php
│       └── form.php
│
└── assets/              # Recursos estáticos
    ├── css/
    │   └── style.css
    └── js/
        └── main.js
```

## 🚀 Instalación

### 1. Requisitos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache con mod_rewrite habilitado
- Servidor local (XAMPP, WAMP, Laragon, etc.)

### 2. Configuración de Base de Datos
1. Importa el archivo `sistema_tutoria.sql` en tu servidor MySQL

### 3. Configuración de la Aplicación
**⚠️ IMPORTANTE:** El archivo `config.php` no está incluido en el repositorio. Debes crearlo:

1. Copia el archivo de ejemplo:
   ```bash
   # Windows (PowerShell)
   Copy-Item config.php.example config.php
   
   # Linux/Mac
   cp config.php.example config.php
   ```

2. Edita `config.php` y configura:
   - Credenciales de base de datos (DB_HOST, DB_NAME, DB_USER, DB_PASS)
   - URL base del proyecto (BASE_URL)
   - Zona horaria según tu región

Para más detalles, consulta [INSTALACION.md](INSTALACION.md)

### 4. Acceso
Abre tu navegador y accede a: `http://localhost/sistemaTutoria/`

## 📖 URLs del Sistema

- **Inicio**: `http://localhost/sistemaTutoria/`
- **Estudiantes**: `http://localhost/sistemaTutoria/index.php?c=estudiante`
- **Tutores**: `http://localhost/sistemaTutoria/index.php?c=tutor`

### Patrón de URLs
- `?c=controlador` - Controlador a ejecutar
- `?a=accion` - Acción del controlador
- `?id=valor` - ID del registro

Ejemplo: `index.php?c=estudiante&a=edit&id=1`

## 🏗️ Arquitectura MVC

### Modelos (models/)
Manejan la lógica de datos y la interacción con la base de datos.
- `Database.php` - Conexión PDO
- `Estudiante.php` - CRUD de estudiantes
- `Tutor.php` - CRUD de tutores

### Vistas (views/)
Presentan la información al usuario en HTML.
- Layout compartido (header/footer)
- Vistas específicas por módulo

### Controladores (controllers/)
Procesan las peticiones y coordinan modelos y vistas.
- `HomeController.php` - Página principal
- `EstudianteController.php` - Gestión de estudiantes
- `TutorController.php` - Gestión de tutores

## ✨ Características

- ✅ Patrón MVC sin frameworks
- ✅ PHP Puro, HTML, CSS y JavaScript
- ✅ PDO para seguridad (prepared statements)
- ✅ CRUD completo de Estudiantes
- ✅ CRUD completo de Tutores
- ✅ Diseño responsive
- ✅ Validación de formularios
- ✅ Sin librerías externas

## 🔧 Desarrollo

### Agregar un nuevo módulo

1. **Crear el Modelo** en `models/`
2. **Crear el Controlador** en `controllers/`
3. **Crear las Vistas** en `views/nuevo_modulo/`
4. **Agregar enlace** en `views/layout/header.php`

### Estructura de un Controlador

```php
<?php
require_once 'models/MiModelo.php';

class MiController {
    public function index() {
        // Código aquí
        require_once 'views/mi/index.php';
    }
}
```

## 📝 Notas Técnicas

- Utiliza PDO con prepared statements para prevenir SQL injection
- Escapado de HTML con `htmlspecialchars()` para prevenir XSS
- Sesiones iniciadas en `config.php`
- Zona horaria configurada para América/Lima

## 👨‍💻 Autor

Desarrollado como proyecto educativo de MVC en PHP puro.

## 📄 Licencia

Proyecto de código abierto para fines educativos.
