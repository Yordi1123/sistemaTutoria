<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Mis Tutorías</h1>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estudiante</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tutorias)): ?>
            <tr>
                <td colspan="6">No tienes tutorías registradas</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tutorias as $tutoria): ?>
                <tr>
                    <td><?= e($tutoria['fecha']) ?></td>
                    <td><?= e($tutoria['hora']) ?></td>
                    <td><?= e($tutoria['estudiante_nombres'] . ' ' . $tutoria['estudiante_apellidos']) ?></td>
                    <td><?= e($tutoria['motivo']) ?></td>
                    <td><?= e($tutoria['estado']) ?></td>
                    <td>
                        <?php if ($tutoria['estado'] === 'confirmada' || $tutoria['estado'] === 'realizada'): ?>
                            <a href="<?= url('tutor/ficha/' . $tutoria['id']) ?>" class="btn btn-primary">Ver/Editar Ficha</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="<?= url('tutor/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

