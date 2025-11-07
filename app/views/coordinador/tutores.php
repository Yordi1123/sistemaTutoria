<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Lista de Tutores</h1>

<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Código</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tutores)): ?>
            <tr>
                <td colspan="6">No hay tutores registrados</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td><?= e($tutor['username']) ?></td>
                    <td><?= e($tutor['docente_codigo'] ?? '-') ?></td>
                    <td><?= e($tutor['docente_nombres'] ?? '-') ?></td>
                    <td><?= e($tutor['docente_apellidos'] ?? '-') ?></td>
                    <td><?= e($tutor['email'] ?? '-') ?></td>
                    <td><?= e($tutor['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('coordinador/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

