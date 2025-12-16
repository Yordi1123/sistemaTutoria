<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📜 Historial de Asignaciones</h2>
    <p>Registro histórico de tutores asignados al estudiante</p>

    <!-- Información del estudiante -->
    <div class="info-card" style="margin-bottom: 2rem;">
        <h4>👨‍🎓 Información del Estudiante</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Nombre:</span>
                <span class="value"><?php echo htmlspecialchars($estudiante['apellidos'] . ', ' . $estudiante['nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Código:</span>
                <span class="value"><?php echo htmlspecialchars($estudiante['codigo']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Ciclo:</span>
                <span class="value"><?php echo htmlspecialchars($estudiante['ciclo']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Escuela:</span>
                <span class="value"><?php echo htmlspecialchars($estudiante['escuela']); ?></span>
            </div>
        </div>
    </div>

    <?php if ($asignacion_actual): ?>
    <div class="current-assignment" style="margin-bottom: 2rem;">
        <h4>✅ Tutor Actual</h4>
        <div class="tutor-card">
            <div class="tutor-info">
                <span class="tutor-name"><?php echo htmlspecialchars($asignacion_actual['docente_apellidos'] . ', ' . $asignacion_actual['docente_nombres']); ?></span>
                <span class="tutor-specialty"><?php echo htmlspecialchars($asignacion_actual['docente_especialidad']); ?></span>
            </div>
            <div class="assignment-date">
                Desde: <?php echo date('d/m/Y', strtotime($asignacion_actual['fecha_asignacion'])); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning" style="margin-bottom: 2rem;">
        <strong>⚠️ Sin asignación:</strong> Este estudiante no tiene un tutor asignado actualmente.
    </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=asignacion" class="btn">← Volver a Asignaciones</a>
    </div>

    <h4>📋 Historial Completo</h4>
    
    <?php if (!empty($historial)): ?>
    <div class="timeline">
        <?php foreach ($historial as $index => $item): ?>
        <div class="timeline-item <?php echo $item['activo'] ? 'active' : 'inactive'; ?>">
            <div class="timeline-marker">
                <?php echo $item['activo'] ? '✅' : '📌'; ?>
            </div>
            <div class="timeline-content">
                <div class="timeline-header">
                    <span class="timeline-date"><?php echo date('d/m/Y', strtotime($item['fecha_asignacion'])); ?></span>
                    <span class="timeline-badge <?php echo $item['activo'] ? 'badge-success' : 'badge-secondary'; ?>">
                        <?php echo $item['activo'] ? 'Activa' : 'Finalizada'; ?>
                    </span>
                </div>
                <div class="timeline-body">
                    <p class="tutor-assigned">
                        <strong>Tutor:</strong> <?php echo htmlspecialchars($item['docente_apellidos'] . ', ' . $item['docente_nombres']); ?>
                    </p>
                    
                    <?php if ($item['docente_anterior_id']): ?>
                    <p class="previous-tutor">
                        <strong>Tutor Anterior:</strong> <?php echo htmlspecialchars($item['docente_anterior_apellidos'] . ', ' . $item['docente_anterior_nombres']); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($item['motivo_reasignacion']): ?>
                    <div class="reasignacion-motivo">
                        <strong>Motivo de reasignación:</strong>
                        <p><?php echo nl2br(htmlspecialchars($item['motivo_reasignacion'])); ?></p>
                        <small>Fecha: <?php echo date('d/m/Y', strtotime($item['fecha_reasignacion'])); ?></small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="text-align: center; padding: 2rem; color: #7f8c8d;">
        No hay registros en el historial de asignaciones.
    </p>
    <?php endif; ?>
</div>

<style>
.info-card {
    background: #e8f4fd;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #3498db;
}
.info-card h4 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.info-item {
    display: flex;
    flex-direction: column;
}
.info-item .label {
    font-size: 0.85rem;
    color: #7f8c8d;
}
.info-item .value {
    font-weight: 600;
    color: #2c3e50;
}

.current-assignment h4 {
    color: #27ae60;
    margin-bottom: 1rem;
}
.tutor-card {
    background: #d4edda;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tutor-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #155724;
}
.tutor-specialty {
    display: block;
    color: #155724;
    font-size: 0.9rem;
}
.assignment-date {
    color: #155724;
    font-size: 0.9rem;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 2rem;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 0.75rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #ddd;
}
.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}
.timeline-marker {
    position: absolute;
    left: -1.5rem;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}
.timeline-content {
    background: #fff;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border-left: 3px solid #3498db;
}
.timeline-item.active .timeline-content {
    border-left-color: #27ae60;
}
.timeline-item.inactive .timeline-content {
    opacity: 0.8;
}
.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}
.timeline-date {
    font-weight: 600;
    color: #2c3e50;
}
.timeline-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}
.badge-success {
    background: #d4edda;
    color: #155724;
}
.badge-secondary {
    background: #e2e3e5;
    color: #41464b;
}
.timeline-body p {
    margin: 0.5rem 0;
}
.reasignacion-motivo {
    background: #fff3cd;
    padding: 0.75rem;
    border-radius: 6px;
    margin-top: 0.75rem;
}
.reasignacion-motivo p {
    margin: 0.25rem 0;
}
.reasignacion-motivo small {
    color: #856404;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
