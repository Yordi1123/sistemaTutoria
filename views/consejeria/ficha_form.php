<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📝 Crear Ficha de Consejería</h2>
    <p>Registra los detalles de la sesión de consejería</p>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.5rem;">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Información de la Consejería -->
    <div class="info-card" style="margin-bottom: 2rem;">
        <h4>📅 Información de la Sesión</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Estudiante:</span>
                <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_apellidos'] . ', ' . $consejeria['estudiante_nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Código:</span>
                <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_codigo']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Fecha:</span>
                <span class="value"><?php echo date('d/m/Y', strtotime($consejeria['fecha'])); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Hora:</span>
                <span class="value"><?php echo date('h:i A', strtotime($consejeria['hora'])); ?></span>
            </div>
        </div>
        <div class="motivo-section">
            <strong>Motivo de consulta:</strong>
            <p><?php echo nl2br(htmlspecialchars($consejeria['motivo'])); ?></p>
        </div>
    </div>

    <form action="index.php?c=consejeria&a=guardarFicha" method="POST" class="form-card">
        <input type="hidden" name="consejeria_id" value="<?php echo $consejeria['id']; ?>">
        
        <div class="form-group">
            <label for="situacion">Situación / Problemática *</label>
            <textarea name="situacion" id="situacion" rows="4" required 
                      placeholder="Describe la situación o problemática identificada..."><?php echo $_SESSION['old']['situacion'] ?? ''; ?></textarea>
            <small>Describe detalladamente la situación presentada por el estudiante</small>
        </div>

        <div class="form-group">
            <label for="intervencion">Intervención Realizada *</label>
            <textarea name="intervencion" id="intervencion" rows="4" required 
                      placeholder="Describe las acciones o intervención realizada..."><?php echo $_SESSION['old']['intervencion'] ?? ''; ?></textarea>
            <small>Detalla las técnicas o estrategias utilizadas durante la sesión</small>
        </div>

        <div class="form-group">
            <label for="conclusiones">Conclusiones y Recomendaciones *</label>
            <textarea name="conclusiones" id="conclusiones" rows="4" required 
                      placeholder="Indica las conclusiones y recomendaciones..."><?php echo $_SESSION['old']['conclusiones'] ?? ''; ?></textarea>
            <small>Incluye las recomendaciones para el estudiante y seguimiento sugerido</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Guardar Ficha</button>
            <a href="index.php?c=consejeria&a=index" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

<style>
.info-card {
    background: #e8f4fd;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #9b59b6;
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
.motivo-section {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(0,0,0,0.1);
}
.motivo-section p {
    margin: 0.5rem 0 0;
}
.form-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 700px;
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
