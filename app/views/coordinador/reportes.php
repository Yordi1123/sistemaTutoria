<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Reportes</h1>

<h2>Tutorías por Estado</h2>
<table>
    <thead>
        <tr>
            <th>Estado</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutoriasPorEstado as $estado): ?>
            <tr>
                <td><?= e($estado['estado']) ?></td>
                <td><?= e($estado['total']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Tutorías por Mes</h2>
<table>
    <thead>
        <tr>
            <th>Mes</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutoriasPorMes as $mes): ?>
            <tr>
                <td><?= e($mes['mes']) ?></td>
                <td><?= e($mes['total']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= url('coordinador/dashboard') ?>" class="btn btn-secondary">Volver al Dashboard</a>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

