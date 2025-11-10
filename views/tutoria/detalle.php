<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📋 Detalle de Tutoría</h2>

    <div class="info-box" style="margin-top: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            
            <!-- Información General -->
            <div>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">📅 Información General</h3>
                <p><strong>Estado:</strong> 
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
                </p>
                <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($tutoria['fecha'])); ?></p>
                <p><strong>Hora:</strong> <?php echo date('h:i A', strtotime($tutoria['hora'])); ?></p>
                <p><strong>Fecha de Solicitud:</strong> <?php echo date('d/m/Y H:i', strtotime($tutoria['fecha_registro'])); ?></p>
            </div>

            <!-- Información del Tutor -->
            <div>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">👨‍🏫 Tutor</h3>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($tutoria['tutor_apellidos'] . ', ' . $tutoria['tutor_nombres']); ?></p>
                <p><strong>Especialidad:</strong> <?php echo htmlspecialchars($tutoria['tutor_especialidad']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($tutoria['tutor_email']); ?></p>
            </div>

            <!-- Información del Estudiante -->
            <?php if ($_SESSION['rol'] != 'estudiante'): ?>
            <div>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">👨‍🎓 Estudiante</h3>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($tutoria['estudiante_apellidos'] . ', ' . $tutoria['estudiante_nombres']); ?></p>
                <p><strong>Código:</strong> <?php echo htmlspecialchars($tutoria['estudiante_codigo']); ?></p>
            </div>
            <?php endif; ?>

        </div>

        <!-- Motivo -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #ddd;">
            <h3 style="color: #2c3e50; margin-bottom: 1rem;">📝 Motivo / Tema</h3>
            <p style="line-height: 1.8;"><?php echo nl2br(htmlspecialchars($tutoria['motivo'])); ?></p>
        </div>

        <!-- Observaciones -->
        <?php if (!empty($tutoria['observaciones'])): ?>
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #ddd;">
            <h3 style="color: #2c3e50; margin-bottom: 1rem;">💬 Observaciones</h3>
            <p style="line-height: 1.8;"><?php echo nl2br(htmlspecialchars($tutoria['observaciones'])); ?></p>
        </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 2rem;">
        <?php if ($_SESSION['rol'] == 'estudiante'): ?>
            <a href="index.php?c=tutoria&a=mistutorias" class="btn">← Volver a Mis Tutorías</a>
            <?php if ($tutoria['estado'] == 'pendiente'): ?>
                <a href="index.php?c=tutoria&a=cancelar&id=<?php echo $tutoria['id']; ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Estás seguro de cancelar esta tutoría?')">Cancelar Tutoría</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="index.php?c=tutoria&a=index" class="btn">← Volver</a>
        <?php endif; ?>
    </div>
</div>

<style>
.badge {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 12px;
    font-size: 0.9rem;
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

