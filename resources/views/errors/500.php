<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del Servidor</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <div class="error-page">
        <h1>500</h1>
        <h2>Error del Servidor</h2>
        <p>Ha ocurrido un error en el servidor. Por favor, intente más tarde.</p>
        <a href="<?= url('/') ?>" class="btn">Volver al inicio</a>
    </div>
</body>
</html>

