<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📝 Ficha de Consejería</h2>

    <div style="margin-bottom: 1.5rem;">
        <a href="javascript:history.back()" class="btn">← Volver</a>
    </div>

    <!-- Información de la Sesión -->
    <div class="info-card" style="margin-bottom: 2rem;">
        <h4>📅 Información de la Sesión</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Fecha:</span>
                <span class="value"><?php echo date('d/m/Y', strtotime($ficha['consejeria_fecha'])); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Hora:</span>
                <span class="value"><?php echo date('h:i A', strtotime($ficha['consejeria_hora'])); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Estudiante:</span>
                <span class="value"><?php echo htmlspecialchars($ficha['estudiante_apellidos'] . ', ' . $ficha['estudiante_nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Código:</span>
                <span class="value"><?php echo htmlspecialchars($ficha['estudiante_codigo']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Consejero:</span>
                <span class="value"><?php echo htmlspecialchars($ficha['consejero_apellidos'] . ', ' . $ficha['consejero_nombres']); ?></span>
            </div>
        </div>
        <div class="motivo-section">
            <strong>Motivo de consulta:</strong>
            <p><?php echo nl2br(htmlspecialchars($ficha['consejeria_motivo'])); ?></p>
        </div>
    </div>

    <!-- Contenido de la Ficha -->
    <div class="ficha-content">
        <div class="ficha-section">
            <h4>🔍 Situación / Problemática</h4>
            <div class="ficha-text">
                <?php echo nl2br(htmlspecialchars($ficha['situacion'])); ?>
            </div>
        </div>

        <div class="ficha-section">
            <h4>🛠️ Intervención Realizada</h4>
            <div class="ficha-text">
                <?php echo nl2br(htmlspecialchars($ficha['intervencion'])); ?>
            </div>
        </div>

        <div class="ficha-section">
            <h4>✅ Conclusiones y Recomendaciones</h4>
            <div class="ficha-text">
                <?php echo nl2br(htmlspecialchars($ficha['conclusiones'])); ?>
            </div>
        </div>
    </div>
</div>

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

.ficha-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.ficha-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}
.ficha-section h4 {
    margin: 0;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
    color: white;
}
.ficha-text {
    padding: 1.5rem;
    color: #555;
    line-height: 1.6;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
