<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Dashboard - Tutor</h1>
<p>Bienvenido, <?= e($_SESSION['usuario']['username']) ?></p>

<div class="stats">
    <div class="stat-card">
        <h3>Solicitudes Pendientes</h3>
        <p><?= $solicitudesPendientes ?></p>
    </div>
    <div class="stat-card">
        <h3>Tutorías Confirmadas</h3>
        <p><?= $tutoriasConfirmadas ?></p>
    </div>
</div>

<a href="<?= url('tutor/solicitudes') ?>" class="btn btn-primary">Ver Solicitudes</a>
<a href="<?= url('tutor/tutorias') ?>" class="btn btn-secondary">Ver Mis Tutorías</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

