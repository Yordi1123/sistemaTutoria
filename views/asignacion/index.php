<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📋 Asignaciones Tutor-Estudiante</h2>
    <p>Gestión de asignaciones permanentes de estudiantes a tutores</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="stats-grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3><?php echo count($asignaciones); ?></h3>
                <p>Estudiantes Asignados</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <h3><?php echo $total_sin_asignar; ?></h3>
                <p>Sin Asignación</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3><?php echo $total_estudiantes; ?></h3>
                <p>Total Estudiantes</p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=asignacion&a=create" class="btn btn-primary">➕ Nueva Asignación</a>
        <a href="index.php?c=dashboard&a=admin" class="btn">← Volver al Dashboard</a>
    </div>

    <?php if ($total_sin_asignar > 0): ?>
    <div class="alert alert-warning" style="margin-bottom: 1.5rem;">
        <strong>⚠️ Atención:</strong> Hay <?php echo $total_sin_asignar; ?> estudiante(s) sin tutor asignado.
        <a href="index.php?c=asignacion&a=create">Asignar ahora</a>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Código</th>
                <th>Ciclo</th>
                <th>Tutor Asignado</th>
                <th>Especialidad</th>
                <th>Fecha Asignación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($asignaciones)): ?>
                <?php foreach ($asignaciones as $asignacion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_apellidos'] . ', ' . $asignacion['estudiante_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_codigo']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_ciclo']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['docente_apellidos'] . ', ' . $asignacion['docente_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['docente_especialidad']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($asignacion['fecha_asignacion'])); ?></td>
                    <td>
                        <a href="index.php?c=asignacion&a=reasignar&id=<?php echo $asignacion['id']; ?>" 
                           class="btn-small btn-warning" title="Reasignar a otro tutor">🔄 Reasignar</a>
                        <a href="index.php?c=asignacion&a=historial&id=<?php echo $asignacion['estudiante_id']; ?>" 
                           class="btn-small" title="Ver historial">📜 Historial</a>
                        <a href="index.php?c=asignacion&a=delete&id=<?php echo $asignacion['id']; ?>" 
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar esta asignación?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No hay asignaciones registradas. <a href="index.php?c=asignacion&a=create">Crear una nueva</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.stat-icon {
    font-size: 2rem;
}
.stat-content h3 {
    margin: 0;
    font-size: 1.5rem;
    color: #2c3e50;
}
.stat-content p {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}
.btn-warning {
    background: #f39c12;
    color: white;
}
.btn-warning:hover {
    background: #e67e22;
}
.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    padding: 1rem;
    border-radius: 8px;
}
.alert-warning a {
    color: #533f03;
    font-weight: bold;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
