<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Sistema de Tutoría' ?></title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <h1>Sistema de Tutoría</h1>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <ul>
                        <?php if ($_SESSION['usuario']['rol'] === 'estudiante'): ?>
                            <li><a href="<?= url('estudiante/dashboard') ?>">Dashboard</a></li>
                            <li><a href="<?= url('estudiante/solicitar') ?>">Solicitar Tutoría</a></li>
                            <li><a href="<?= url('estudiante/mis-tutorias') ?>">Mis Tutorías</a></li>
                        <?php elseif ($_SESSION['usuario']['rol'] === 'docente'): ?>
                            <li><a href="<?= url('tutor/dashboard') ?>">Dashboard</a></li>
                            <li><a href="<?= url('tutor/solicitudes') ?>">Solicitudes</a></li>
                            <li><a href="<?= url('tutor/tutorias') ?>">Mis Tutorías</a></li>
                        <?php elseif ($_SESSION['usuario']['rol'] === 'coordinador'): ?>
                            <li><a href="<?= url('coordinador/dashboard') ?>">Dashboard</a></li>
                            <li><a href="<?= url('coordinador/tutores') ?>">Tutores</a></li>
                            <li><a href="<?= url('coordinador/estudiantes') ?>">Estudiantes</a></li>
                            <li><a href="<?= url('coordinador/reportes') ?>">Reportes</a></li>
                        <?php endif; ?>
                        <li><a href="<?= url('logout') ?>">Cerrar Sesión</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= e($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= e($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

