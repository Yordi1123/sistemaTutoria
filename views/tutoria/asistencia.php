<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>✅ Confirmar Asistencia</h2>
    <p>Tutorías programadas para hoy</p>

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

    <?php if (!empty($tutoriasHoy)): ?>
        <div class="tutorias-hoy">
            <?php foreach ($tutoriasHoy as $tutoria): ?>
                <div class="tutoria-card">
                    <div class="tutoria-header">
                        <h3>🕐 <?php echo date('h:i A', strtotime($tutoria['hora'])); ?></h3>
                        <span class="badge <?php echo $tutoria['estado'] == 'realizada' ? 'badge-success' : 'badge-info'; ?>">
                            <?php echo ucfirst($tutoria['estado']); ?>
                        </span>
                    </div>

                    <div class="tutoria-body">
                        <p><strong>👨‍🏫 Tutor:</strong> <?php echo htmlspecialchars($tutoria['tutor_apellidos'] . ', ' . $tutoria['tutor_nombres']); ?></p>
                        <p><strong>📚 Especialidad:</strong> <?php echo htmlspecialchars($tutoria['tutor_especialidad']); ?></p>
                        <p><strong>📝 Motivo:</strong> <?php echo htmlspecialchars(substr($tutoria['motivo'], 0, 100)) . '...'; ?></p>
                    </div>

                    <div class="tutoria-actions">
                        <a href="index.php?c=tutoria&a=detalle&id=<?php echo $tutoria['id']; ?>" 
                           class="btn btn-small">Ver Detalle</a>
                        
                        <?php if ($tutoria['estado'] != 'realizada'): ?>
                            <a href="index.php?c=tutoria&a=confirmar&id=<?php echo $tutoria['id']; ?>" 
                               class="btn btn-small btn-primary"
                               onclick="return confirm('¿Confirmas tu asistencia a esta tutoría?')">
                               ✅ Confirmar Asistencia
                            </a>
                        <?php else: ?>
                            <span class="btn btn-small btn-success" style="cursor: default;">
                                ✓ Asistencia Confirmada
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="info-box" style="text-align: center; padding: 3rem;">
            <p style="font-size: 3rem; margin-bottom: 1rem;">📅</p>
            <p style="font-size: 1.2rem; color: #7f8c8d;">No tienes tutorías programadas para hoy</p>
            <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary" style="margin-top: 1.5rem;">
                Solicitar Tutoría
            </a>
        </div>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="index.php?c=dashboard&a=estudiante" class="btn">← Volver al Dashboard</a>
    </div>
</div>

<style>
.tutorias-hoy {
    display: grid;
    gap: 1.5rem;
    margin-top: 2rem;
}

.tutoria-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #3498db;
}

.tutoria-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.tutoria-header h3 {
    margin: 0;
    color: #2c3e50;
}

.tutoria-body p {
    margin: 0.5rem 0;
    line-height: 1.6;
}

.tutoria-actions {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
    display: flex;
    gap: 1rem;
}

.badge {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
}

.badge-success {
    background: #d1e7dd;
    color: #0f5132;
}

.badge-info {
    background: #cfe2ff;
    color: #084298;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

