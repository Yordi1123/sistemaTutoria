<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>❌ Registrar Inasistencia</h2>
    <p>Registrar la inasistencia del estudiante a la tutoría</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Información de la tutoría -->
    <div class="info-card" style="margin-bottom: 2rem;">
        <h4>📋 Información de la Tutoría</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Estudiante:</span>
                <span class="value"><?php echo htmlspecialchars($tutoria['estudiante_apellidos'] . ', ' . $tutoria['estudiante_nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Fecha:</span>
                <span class="value"><?php echo date('d/m/Y', strtotime($tutoria['fecha'])); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Hora:</span>
                <span class="value"><?php echo date('h:i A', strtotime($tutoria['hora'])); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Motivo:</span>
                <span class="value"><?php echo htmlspecialchars($tutoria['motivo']); ?></span>
            </div>
        </div>
    </div>

    <form action="index.php?c=tutoria&a=registrarInasistencia&id=<?php echo $tutoria['id']; ?>" method="POST" class="form-card">
        
        <div class="form-group">
            <label for="justificacion">Justificación de la Inasistencia *</label>
            <textarea name="justificacion" id="justificacion" rows="4" required 
                      placeholder="Describa el motivo por el cual el estudiante no asistió a la tutoría..."></textarea>
            <small>Esta información quedará registrada en las observaciones de la tutoría</small>
        </div>

        <div class="alert alert-warning" style="margin-bottom: 1.5rem;">
            <strong>⚠️ Importante:</strong> Al registrar la inasistencia, la tutoría quedará marcada como cancelada 
            y no podrá modificarse posteriormente.
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-danger">❌ Confirmar Inasistencia</button>
            <a href="index.php?c=tutoria&a=mistutoriasdocente" class="btn">Cancelar</a>
        </div>
    </form>
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
.form-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 600px;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
}
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    font-family: inherit;
}
.form-group small {
    display: block;
    margin-top: 0.25rem;
    color: #7f8c8d;
    font-size: 0.85rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
