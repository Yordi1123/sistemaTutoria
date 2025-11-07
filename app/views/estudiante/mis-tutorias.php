<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Mis Tutorías</h1>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Docente</th>
            <th>Motivo</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tutorias)): ?>
            <tr>
                <td colspan="5">No tienes tutorías registradas</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tutorias as $tutoria): ?>
                <tr>
                    <td><?= e($tutoria['fecha']) ?></td>
                    <td><?= e($tutoria['hora']) ?></td>
                    <td><?= e($tutoria['docente_nombres'] . ' ' . $tutoria['docente_apellidos']) ?></td>
                    <td><?= e($tutoria['motivo']) ?></td>
                    <td><?= e($tutoria['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('estudiante/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

