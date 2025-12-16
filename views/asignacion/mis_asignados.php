<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>👥 Mis Estudiantes Asignados</h2>
    <p>Lista de estudiantes asignados permanentemente bajo tu tutoría</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
    </div>

    <?php if (!empty($estudiantes_asignados)): ?>
        <div class="estudiantes-grid">
            <?php foreach ($estudiantes_asignados as $est): ?>
            <div class="estudiante-card">
                <div class="estudiante-avatar">👨‍🎓</div>
                <div class="estudiante-info">
                    <h4><?php echo htmlspecialchars($est['estudiante_apellidos'] . ', ' . $est['estudiante_nombres']); ?></h4>
                    <p class="codigo"><?php echo htmlspecialchars($est['estudiante_codigo']); ?></p>
                    <div class="details">
                        <span>📚 Ciclo <?php echo htmlspecialchars($est['estudiante_ciclo']); ?></span>
                        <span>🏫 <?php echo htmlspecialchars($est['estudiante_escuela']); ?></span>
                    </div>
                    <?php if ($est['estudiante_email']): ?>
                    <p class="email">📧 <?php echo htmlspecialchars($est['estudiante_email']); ?></p>
                    <?php endif; ?>
                    <p class="fecha-asignacion">
                        <small>Asignado desde: <?php echo date('d/m/Y', strtotime($est['fecha_asignacion'])); ?></small>
                    </p>
                </div>
                <div class="estudiante-actions">
                    <a href="index.php?c=seguimiento&a=ver&id=<?php echo $est['estudiante_id']; ?>" 
                       class="btn-small btn-primary">📋 Ver Seguimientos</a>
                    <a href="index.php?c=seguimiento&a=crear&id=<?php echo $est['estudiante_id']; ?>" 
                       class="btn-small btn-success">➕ Nuevo Seguimiento</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <h3>No tienes estudiantes asignados</h3>
            <p>El coordinador debe asignarte estudiantes para que aparezcan aquí.</p>
            <p>Mientras tanto, puedes atender solicitudes de tutoría de cualquier estudiante.</p>
            <a href="index.php?c=tutoria&a=solicitudes" class="btn btn-primary">Ver Solicitudes Pendientes</a>
        </div>
    <?php endif; ?>
</div>

<style>
.estudiantes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}
.estudiante-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.estudiante-avatar {
    font-size: 3rem;
    text-align: center;
}
.estudiante-info h4 {
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}
.estudiante-info .codigo {
    color: #3498db;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
}
.estudiante-info .details {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}
.estudiante-info .email {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0.25rem 0;
}
.estudiante-info .fecha-asignacion {
    margin: 0.5rem 0 0 0;
    color: #27ae60;
}
.estudiante-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    border-top: 1px solid #eee;
    padding-top: 1rem;
}
.btn-success {
    background: #27ae60;
    color: white;
}
.btn-success:hover {
    background: #219a52;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 12px;
}
.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}
.empty-state h3 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}
.empty-state p {
    color: #7f8c8d;
    margin-bottom: 0.5rem;
}
.empty-state .btn {
    margin-top: 1rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
