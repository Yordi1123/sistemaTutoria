<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Solicitudes de Tutoría</h1>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= e($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estudiante</th>
            <th>Motivo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($solicitudes)): ?>
            <tr>
                <td colspan="5">No hay solicitudes pendientes</td>
            </tr>
        <?php else: ?>
            <?php foreach ($solicitudes as $solicitud): ?>
                <tr>
                    <td><?= e($solicitud['fecha']) ?></td>
                    <td><?= e($solicitud['hora']) ?></td>
                    <td><?= e($solicitud['estudiante_nombres'] . ' ' . $solicitud['estudiante_apellidos']) ?></td>
                    <td><?= e($solicitud['motivo']) ?></td>
                    <td>
                        <a href="<?= url('tutor/solicitudes/' . $solicitud['id'] . '/aceptar') ?>" class="btn btn-success">Aceptar</a>
                        <a href="<?= url('tutor/solicitudes/' . $solicitud['id'] . '/rechazar') ?>" class="btn btn-danger">Rechazar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('tutor/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

