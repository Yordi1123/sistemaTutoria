# Sistema Académico - MVC PHP

Sistema web desarrollado con PHP utilizando el patrón Modelo-Vista-Controlador (MVC) sin frameworks.

## Estructura del Proyecto

```
sistemaAcademico/
│
├── public/                      # Carpeta pública (DocumentRoot)
│   ├── index.php               # Punto de entrada
│   ├── .htaccess               # Reescritura de URLs
│   └── assets/
│       ├── css/
│       │   └── style.css
│       ├── js/
│       │   └── script.js
│       └── img/
│
├── app/                         # Aplicación (fuera de public)
│   ├── config/
│   │   ├── config.php          # Configuración general
│   │   └── database.php        # Configuración BD
│   │
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── ProductoController.php
│   │   └── UsuarioController.php
│   │
│   ├── models/
│   │   ├── Database.php
│   │   ├── Model.php
│   │   ├── Producto.php
│   │   └── Usuario.php
│   │
│   ├── views/
│   │   ├── layout/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── home/
│   │   │   └── index.php
│   │   ├── productos/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   └── errors/
│   │       └── 404.php
│   │
│   ├── core/
│   │   ├── Controller.php      # Clase base controladores
│   │   └── Router.php          # Sistema de enrutamiento
│   │
│   └── helpers/
│       └── functions.php
│
├── storage/                     # Archivos de la aplicación
│   ├── logs/
│   │   └── .htaccess           # Denegar acceso
│   └── uploads/
│       └── .htaccess
│
├── database/                    # Scripts SQL de base de datos
│   ├── create_database.sql     # Script de creación de BD y tablas
│   └── README.md               # Documentación de scripts
│
├── .env.example                 # Ejemplo de configuración
├── .gitignore                   # Ignorar archivos sensibles
└── README.md                    # Documentación
```

## Requisitos

- PHP >= 7.4
- Apache con mod_rewrite habilitado
- MySQL/MariaDB
- Composer

## Instalación

1. Clonar o descargar el proyecto

2. Instalar dependencias de Composer:
```bash
composer install
```

3. Copiar el archivo de configuración de ejemplo:
```bash
cp .env.example .env
```

4. Configurar la base de datos en `app/config/database.php`:
```php
return [
    'host' => 'localhost',
    'dbname' => 'sistema_academico',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    // ...
];
```

5. Crear la base de datos y las tablas:
   
   **Opción A - Desde la línea de comandos:**
   ```bash
   mysql -u root -p < database/create_database.sql
   ```
   
   **Opción B - Desde phpMyAdmin:**
   - Abre phpMyAdmin
   - Ve a la pestaña "SQL"
   - Copia y pega el contenido de `database/create_database.sql`
   - Ejecuta el script

6. Asegurarse de que el servidor web apunte al directorio `public/`

## Uso

### Crear un nuevo Controlador

1. Crear un archivo en `app/controllers/`:
```php
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\TuModelo;

class TuController extends Controller
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new TuModelo();
    }

    public function index()
    {
        $data = ['title' => 'Título'];
        $this->render('vista/index', $data);
    }
}
```

2. Agregar la ruta en `public/index.php`:
```php
$router->get('/ruta', 'TuController', 'index');
```

### Crear un nuevo Modelo

1. Crear un archivo en `app/models/`:
```php
<?php
namespace App\Models;

class TuModelo extends Model
{
    protected $table = 'tu_tabla';
}
```

### Crear una Vista

1. Crear un archivo en `app/views/`:
```php
<div class="mi-vista">
    <h1><?= e($title ?? 'Título') ?></h1>
    <!-- Contenido -->
</div>
```

## Rutas Disponibles

- `GET /` - Página de inicio
- `GET /productos` - Lista de productos
- `GET /productos/create` - Formulario crear producto
- `POST /productos` - Guardar producto
- `GET /productos/{id}` - Ver producto
- `GET /productos/{id}/edit` - Formulario editar producto
- `POST /productos/{id}` - Actualizar producto
- `GET /productos/{id}/delete` - Eliminar producto

## Helpers Disponibles

- `asset(string $path)` - Obtiene la URL de un asset
- `url(string $path)` - Genera URLs
- `redirect(string $url)` - Redirige
- `e(string $value)` - Escapa HTML
- `csrf_token()` - Genera token CSRF
- `csrf_field()` - Genera campo hidden CSRF
- `flash(string $key, $value)` - Mensajes flash
- `old(string $key, $default)` - Valor anterior de input
- `dd(...$vars)` - Dump and die

## Configuración del Servidor

### Apache

Asegúrate de que `mod_rewrite` esté habilitado y configura el DocumentRoot para apuntar a la carpeta `public/`.

### Nginx

```nginx
server {
    listen 80;
    server_name localhost;
    root /ruta/a/sistemaAcademico/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Desarrollo

Para desarrollo, configura `APP_ENV` en `app/config/config.php`:
```php
define('APP_ENV', 'development');
```

Esto habilitará la visualización de errores.

## Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.
