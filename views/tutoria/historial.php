<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📊 Historial de Tutorías</h2>
    <p>Consulta todas tus tutorías y estadísticas</p>

    <!-- Estadísticas -->
    <div class="stats-grid" style="margin: 2rem 0;">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-content">
                <h3><?php echo $estadisticas['total']; ?></h3>
                <p>Total</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <h3><?php echo $estadisticas['pendientes']; ?></h3>
                <p>Pendientes</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?php echo $estadisticas['realizadas']; ?></h3>
                <p>Realizadas</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">❌</div>
            <div class="stat-content">
                <h3><?php echo $estadisticas['canceladas']; ?></h3>
                <p>Canceladas</p>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros" style="margin-bottom: 1.5rem;">
        <strong>Filtrar por estado:</strong>
        <a href="index.php?c=tutoria&a=historial" class="btn btn-small <?php echo !isset($_GET['estado']) ? 'btn-primary' : ''; ?>">Todas</a>
        <a href="index.php?c=tutoria&a=historial&estado=pendiente" class="btn btn-small <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'btn-primary' : ''; ?>">Pendientes</a>
        <a href="index.php?c=tutoria&a=historial&estado=confirmada" class="btn btn-small <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'confirmada') ? 'btn-primary' : ''; ?>">Confirmadas</a>
        <a href="index.php?c=tutoria&a=historial&estado=realizada" class="btn btn-small <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'realizada') ? 'btn-primary' : ''; ?>">Realizadas</a>
        <a href="index.php?c=tutoria&a=historial&estado=cancelada" class="btn btn-small <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'cancelada') ? 'btn-primary' : ''; ?>">Canceladas</a>
    </div>

    <!-- Tabla -->
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
                    <td><?php echo htmlspecialchars(substr($tutoria['motivo'], 0, 40)) . '...'; ?></td>
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
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No se encontraron tutorías con este filtro
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        <a href="index.php?c=dashboard&a=estudiante" class="btn">← Volver al Dashboard</a>
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

