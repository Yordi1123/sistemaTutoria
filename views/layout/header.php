<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body <?php 
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['rol'] == 'coordinador') {
            echo 'class="dashboard-admin"';
        } elseif ($_SESSION['rol'] == 'docente') {
            echo 'class="dashboard-docente"';
        } elseif ($_SESSION['rol'] == 'estudiante') {
            echo 'class="dashboard-estudiante"';
        } elseif ($_SESSION['rol'] == 'consejero') {
            echo 'class="dashboard-consejero"';
        }
    }
?>>
    <header class="dashboard-header">
        <nav>
            <div class="nav-brand">
                <h1><?php echo APP_NAME; ?></h1>
            </div>
            <ul class="nav-menu">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['rol'] == 'coordinador'): ?>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=dashboard&a=admin">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=estudiante">Estudiantes</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=tutor">Tutores</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejero">Consejeros</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=asignacion">Asignaciones</a></li>
                    <?php elseif ($_SESSION['rol'] == 'docente'): ?>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=dashboard&a=docente">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=estudiante">Estudiantes</a></li>
                    <?php elseif ($_SESSION['rol'] == 'estudiante'): ?>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=dashboard&a=estudiante">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=tutor">Tutores</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejeria&a=misConsejerias">Consejería</a></li>
                    <?php elseif ($_SESSION['rol'] == 'consejero'): ?>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejeria&a=dashboard">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejeria&a=solicitudes">Solicitudes</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejeria&a=index">Consejerías</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?c=consejeria&a=misFichas">Fichas</a></li>
                    <?php endif; ?>
                    <li class="nav-user">
                        <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="<?php echo BASE_URL; ?>index.php?c=auth&a=logout" class="btn btn-small btn-danger">Salir</a>
                    </li>
                <?php else: ?>
                    <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?c=auth&a=login">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="dashboard-main">

