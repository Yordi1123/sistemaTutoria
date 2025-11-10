<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📚 Mis Tutorías</h2>
    <p>Todas tus solicitudes de tutoría</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary">📝 Nueva Solicitud</a>
        <a href="index.php?c=tutoria&a=historial" class="btn">📊 Ver Historial</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tutor</th>
                <th>Especialidad</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tutorias)): ?>
                <?php foreach ($tutorias as $tutoria): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($tutoria['fecha'])); ?></td>
                    <td><?php echo date('h:i A', strtotime($tutoria['hora'])); ?></td>
                    <td><?php echo htmlspecialchars($tutoria['tutor_apellidos'] . ', ' . $tutoria['tutor_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($tutoria['tutor_especialidad']); ?></td>
                    <td><?php echo htmlspecialchars(substr($tutoria['motivo'], 0, 50)) . '...'; ?></td>
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
                           class="btn-small btn-primary">👁️ Ver</a>
                        <?php if (in_array($tutoria['estado'], ['pendiente', 'confirmada'])): ?>
                            <a href="index.php?c=tutoria&a=reprogramar&id=<?php echo $tutoria['id']; ?>" 
                               class="btn-small btn-warning">📅 Reprogramar</a>
                        <?php endif; ?>
                        <?php if ($tutoria['estado'] == 'pendiente'): ?>
                            <a href="index.php?c=tutoria&a=cancelar&id=<?php echo $tutoria['id']; ?>" 
                               class="btn-small btn-danger"
                               onclick="return confirm('¿Estás seguro de cancelar esta tutoría?')">❌ Cancelar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        <p>No tienes tutorías solicitadas</p>
                        <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary" style="margin-top: 1rem;">
                            Solicitar mi primera tutoría
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
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

