<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📋 Detalle de Consejería</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="javascript:history.back()" class="btn">← Volver</a>
    </div>

    <div class="detalle-grid">
        <!-- Información de la Consejería -->
        <div class="info-card">
            <h4>📅 Información de la Cita</h4>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Fecha:</span>
                    <span class="value"><?php echo date('d/m/Y', strtotime($consejeria['fecha'])); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Hora:</span>
                    <span class="value"><?php echo date('h:i A', strtotime($consejeria['hora'])); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Estado:</span>
                    <span class="value">
                        <?php
                        $badge_class = '';
                        switch($consejeria['estado']) {
                            case 'pendiente': $badge_class = 'badge-warning'; break;
                            case 'confirmada': $badge_class = 'badge-info'; break;
                            case 'realizada': $badge_class = 'badge-success'; break;
                            case 'cancelada': $badge_class = 'badge-danger'; break;
                        }
                        ?>
                        <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($consejeria['estado']); ?></span>
                    </span>
                </div>
            </div>
            <div class="motivo-section">
                <strong>Motivo:</strong>
                <p><?php echo nl2br(htmlspecialchars($consejeria['motivo'])); ?></p>
            </div>
            <?php if ($consejeria['observaciones']): ?>
            <div class="observaciones-section">
                <strong>Observaciones:</strong>
                <p><?php echo nl2br(htmlspecialchars($consejeria['observaciones'])); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Información del Estudiante -->
        <div class="info-card">
            <h4>👨‍🎓 Estudiante</h4>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nombre:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_apellidos'] . ', ' . $consejeria['estudiante_nombres']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Código:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_codigo']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Ciclo:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_ciclo']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['estudiante_email']); ?></span>
                </div>
            </div>
        </div>

        <!-- Información del Consejero -->
        <div class="info-card">
            <h4>🧠 Consejero</h4>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nombre:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['consejero_apellidos'] . ', ' . $consejeria['consejero_nombres']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Especialidad:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['consejero_especialidad']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value"><?php echo htmlspecialchars($consejeria['consejero_email']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Ficha de Consejería (si existe) -->
    <?php if ($ficha): ?>
    <div class="ficha-section">
        <h3>📝 Ficha de Consejería</h3>
        <div class="ficha-card">
            <div class="ficha-item">
                <h5>Situación</h5>
                <p><?php echo nl2br(htmlspecialchars($ficha['situacion'])); ?></p>
            </div>
            <div class="ficha-item">
                <h5>Intervención</h5>
                <p><?php echo nl2br(htmlspecialchars($ficha['intervencion'])); ?></p>
            </div>
            <div class="ficha-item">
                <h5>Conclusiones</h5>
                <p><?php echo nl2br(htmlspecialchars($ficha['conclusiones'])); ?></p>
            </div>
        </div>
    </div>
    <?php elseif ($consejeria['estado'] == 'realizada' && $_SESSION['rol'] == 'consejero'): ?>
    <div class="alert alert-warning" style="margin-top: 1.5rem;">
        <strong>⚠️ Pendiente:</strong> No se ha registrado la ficha de esta consejería.
        <a href="index.php?c=consejeria&a=crearFicha&id=<?php echo $consejeria['id']; ?>" class="btn btn-primary btn-small" style="margin-left: 1rem;">Crear Ficha</a>
    </div>
    <?php endif; ?>
</div>

<style>
.detalle-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}
.info-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.info-card h4 {
    margin: 0 0 1rem;
    color: #2c3e50;
    border-bottom: 2px solid #9b59b6;
    padding-bottom: 0.5rem;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
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
.motivo-section, .observaciones-section {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}
.motivo-section p, .observaciones-section p {
    margin: 0.5rem 0 0;
    color: #555;
}
.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.8rem;
}
.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #cfe2ff; color: #084298; }
.badge-success { background: #d1e7dd; color: #0f5132; }
.badge-danger { background: #f8d7da; color: #842029; }

.ficha-section {
    margin-top: 2rem;
}
.ficha-section h3 {
    margin-bottom: 1rem;
}
.ficha-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.ficha-item {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}
.ficha-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.ficha-item h5 {
    margin: 0 0 0.5rem;
    color: #9b59b6;
}
.ficha-item p {
    margin: 0;
    color: #555;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
