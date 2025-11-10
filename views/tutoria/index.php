<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📚 Todas las Tutorías</h2>
    <p>Gestión general de tutorías del sistema</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Código</th>
                <th>Tutor</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tutorias)): ?>
                <?php foreach ($tutorias as $tutoria): ?>
                <tr>
                    <td><?php echo $tutoria['id']; ?></td>
                    <td><?php echo htmlspecialchars($tutoria['estudiante_apellidos'] . ', ' . $tutoria['estudiante_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($tutoria['estudiante_codigo']); ?></td>
                    <td><?php echo htmlspecialchars($tutoria['tutor_apellidos'] . ', ' . $tutoria['tutor_nombres']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($tutoria['fecha'])); ?></td>
                    <td><?php echo date('h:i A', strtotime($tutoria['hora'])); ?></td>
                    <td>
                        <?php
                        $badge_class = '';
                        switch($tutoria['estado']) {
                            case 'pendiente':
                                $badge_class = 'badge-warning';
                                break;
                            case 'confirmada':
                                $badge_class = 'badge-info';
                                break;
                            case 'realizada':
                                $badge_class = 'badge-success';
                                break;
                            case 'cancelada':
                                $badge_class = 'badge-danger';
                                break;
                        }
                        ?>
                        <span class="badge <?php echo $badge_class; ?>">
                            <?php echo ucfirst($tutoria['estado']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?c=tutoria&a=detalle&id=<?php echo $tutoria['id']; ?>" 
                           class="btn-small">Ver Detalle</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2rem;">
                        No hay tutorías registradas en el sistema
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="index.php?c=dashboard&a=admin" class="btn">← Volver al Dashboard</a>
    </div>
</div>

<style>
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}

.badge-info {
    background: #cfe2ff;
    color: #084298;
}

.badge-success {
    background: #d1e7dd;
    color: #0f5132;
}

.badge-danger {
    background: #f8d7da;
    color: #842029;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

