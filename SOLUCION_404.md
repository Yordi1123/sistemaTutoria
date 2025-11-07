# Solución al Error 404

## Problema
Al acceder a la aplicación aparece "Not Found - The requested URL was not found on this server."

## Soluciones

### 1. Verificar que mod_rewrite esté habilitado en Apache

Edita el archivo `C:\xampp\apache\conf\httpd.conf` y busca:
```apache
#LoadModule rewrite_module modules/mod_rewrite.so
```

Descomenta la línea (quita el #):
```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

Luego reinicia Apache desde el Panel de Control de XAMPP.

### 2. Verificar la URL de acceso

Debes acceder usando una de estas URLs:

**Opción A (Recomendada):**
```
http://localhost/sistemaAcademico/public/
```

**Opción B:**
```
http://localhost/sistemaAcademico/public/index.php
```

### 3. Probar si PHP funciona

Accede a:
```
http://localhost/sistemaAcademico/public/test.php
```

Si esto funciona, PHP está bien configurado.

### 4. Si aún no funciona, cambiar el DocumentRoot (Opcional)

Si quieres acceder directamente a `http://localhost/sistemaAcademico/` sin `/public`:

1. Edita `C:\xampp\apache\conf\httpd.conf`
2. Busca la sección del VirtualHost de localhost
3. Cambia el DocumentRoot a:
```apache
DocumentRoot "C:/xampp/htdocs/sistemaAcademico/public"
<Directory "C:/xampp/htdocs/sistemaAcademico/public">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

4. Reinicia Apache

### 5. Verificar permisos del .htaccess

Asegúrate de que el archivo `.htaccess` en la carpeta `public/` tenga permisos de lectura.

## Pruebas rápidas

1. **Probar PHP:** `http://localhost/sistemaAcademico/public/test.php`
2. **Probar index.php directo:** `http://localhost/sistemaAcademico/public/index.php`
3. **Probar login:** `http://localhost/sistemaAcademico/public/login`

## Notas

- Si mod_rewrite no está habilitado, el .htaccess no funcionará
- Si accedes directamente a index.php, debería funcionar sin mod_rewrite
- El archivo test.php te ayudará a diagnosticar el problema

