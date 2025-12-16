<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📅 Mis Consejerías</h2>
    <p>Historial de consejerías programadas y realizadas</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=consejeria&a=solicitudes" class="btn btn-primary">📨 Solicitudes Pendientes</a>
        <a href="index.php?c=consejeria&a=dashboard" class="btn">← Volver al Dashboard</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estudiante</th>
                <th>Código</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($consejerias)): ?>
                <?php foreach ($consejerias as $consejeria): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($consejeria['fecha'])); ?></td>
                    <td><?php echo date('h:i A', strtotime($consejeria['hora'])); ?></td>
                    <td><?php echo htmlspecialchars($consejeria['estudiante_apellidos'] . ', ' . $consejeria['estudiante_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($consejeria['estudiante_codigo']); ?></td>
                    <td><?php echo htmlspecialchars(substr($consejeria['motivo'], 0, 40)) . '...'; ?></td>
                    <td>
                        <?php
                        $badge_class = '';
                        switch($consejeria['estado']) {
                            case 'pendiente': $badge_class = 'badge-warning'; break;
                            case 'confirmada': $badge_class = 'badge-info'; break;
                            case 'realizada': $badge_class = 'badge-success'; break;
                            case 'cancelada': $badge_class = 'badge-danger'; break;
                        }
                        ?>
                        <span class="badge <?php echo $badge_class; ?>">
                            <?php echo ucfirst($consejeria['estado']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?c=consejeria&a=detalle&id=<?php echo $consejeria['id']; ?>" 
                           class="btn-small">Ver Detalle</a>
                        <?php if ($consejeria['estado'] == 'confirmada'): ?>
                            <a href="index.php?c=consejeria&a=marcarRealizada&id=<?php echo $consejeria['id']; ?>" 
                               class="btn-small btn-success"
                               onclick="return confirm('¿Marcar esta consejería como realizada?')">✅ Realizada</a>
                        <?php endif; ?>
                        <?php if ($consejeria['estado'] == 'realizada'): ?>
                            <a href="index.php?c=consejeria&a=crearFicha&id=<?php echo $consejeria['id']; ?>" 
                               class="btn-small btn-primary">📝 Ficha</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No tienes consejerías registradas
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
.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #cfe2ff; color: #084298; }
.badge-success { background: #d1e7dd; color: #0f5132; }
.badge-danger { background: #f8d7da; color: #842029; }
.btn-success { background: #27ae60; color: white; }
</style>

<?php require_once 'views/layout/footer.php'; ?>
