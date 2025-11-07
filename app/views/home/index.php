<div class="home-page">
    <h1><?= isset($message) ? htmlspecialchars($message) : 'Bienvenido' ?></h1>
    <p>Este es el sistema académico desarrollado con PHP usando el patrón MVC.</p>
    
    <div class="info-box">
        <h2>Estructura del Proyecto</h2>
        <ul>
            <li><strong>app/controllers/</strong> - Controladores</li>
            <li><strong>app/models/</strong> - Modelos</li>
            <li><strong>app/views/</strong> - Vistas</li>
            <li><strong>app/core/</strong> - Núcleo del sistema</li>
            <li><strong>app/config/</strong> - Configuración</li>
            <li><strong>app/helpers/</strong> - Funciones helper</li>
            <li><strong>public/assets/</strong> - Archivos públicos (CSS, JS, imágenes)</li>
            <li><strong>storage/</strong> - Logs y archivos subidos</li>
        </ul>
    </div>
</div>
