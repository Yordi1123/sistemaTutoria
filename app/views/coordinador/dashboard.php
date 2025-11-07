<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Dashboard - Coordinador</h1>
<p>Bienvenido, <?= e($_SESSION['usuario']['username']) ?></p>

<div class="stats">
    <div class="stat-card">
        <h3>Total Tutorías</h3>
        <p><?= $totalTutorias ?></p>
    </div>
    <div class="stat-card">
        <h3>Tutorías Pendientes</h3>
        <p><?= $tutoriasPendientes ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Tutores</h3>
        <p><?= $totalTutores ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Estudiantes</h3>
        <p><?= $totalEstudiantes ?></p>
    </div>
</div>

<a href="<?= url('coordinador/tutores') ?>" class="btn btn-primary">Ver Tutores</a>
<a href="<?= url('coordinador/estudiantes') ?>" class="btn btn-primary">Ver Estudiantes</a>
<a href="<?= url('coordinador/reportes') ?>" class="btn btn-secondary">Ver Reportes</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

