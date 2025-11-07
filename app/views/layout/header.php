<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Sistema Académico' ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <h1>Sistema Académico</h1>
                <ul>
                    <li><a href="<?= url('/') ?>">Inicio</a></li>
                    <li><a href="<?= url('productos') ?>">Productos</a></li>
                    <li><a href="<?= url('usuarios') ?>">Usuarios</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container">

