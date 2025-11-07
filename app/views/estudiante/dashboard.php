<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Dashboard - Estudiante</h1>
<p>Bienvenido, <?= e($_SESSION['usuario']['username']) ?></p>

<div class="stats">
    <div class="stat-card">
        <h3>Mis Tutorías</h3>
        <p><?= count($tutorias) ?></p>
    </div>
</div>

<h2>Últimas Tutorías</h2>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Docente</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tutorias)): ?>
            <tr>
                <td colspan="4">No tienes tutorías registradas</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tutorias as $tutoria): ?>
                <tr>
                    <td><?= e($tutoria['fecha']) ?></td>
                    <td><?= e($tutoria['hora']) ?></td>
                    <td><?= e($tutoria['docente_nombres'] . ' ' . $tutoria['docente_apellidos']) ?></td>
                    <td><?= e($tutoria['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('estudiante/solicitar') ?>" class="btn btn-primary">Solicitar Nueva Tutoría</a>
<a href="<?= url('estudiante/mis-tutorias') ?>" class="btn btn-secondary">Ver Todas mis Tutorías</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

