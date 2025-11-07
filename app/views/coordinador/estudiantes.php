<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Lista de Estudiantes</h1>

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
        <?php if (empty($estudiantes)): ?>
            <tr>
                <td colspan="6">No hay estudiantes registrados</td>
            </tr>
        <?php else: ?>
            <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= e($estudiante['username']) ?></td>
                    <td><?= e($estudiante['estudiante_codigo'] ?? '-') ?></td>
                    <td><?= e($estudiante['estudiante_nombres'] ?? '-') ?></td>
                    <td><?= e($estudiante['estudiante_apellidos'] ?? '-') ?></td>
                    <td><?= e($estudiante['email'] ?? '-') ?></td>
                    <td><?= e($estudiante['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('coordinador/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

