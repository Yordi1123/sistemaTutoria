<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📩 Solicitudes Pendientes</h2>
    <p>Solicitudes de consejería que requieren tu atención</p>

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

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=consejeria&a=dashboard" class="btn">← Volver al Dashboard</a>
    </div>

    <?php if (!empty($solicitudes)): ?>
        <div class="solicitudes-grid">
            <?php foreach ($solicitudes as $sol): ?>
            <div class="solicitud-card">
                <div class="solicitud-header">
                    <span class="fecha"><?php echo date('d/m/Y', strtotime($sol['fecha'])); ?></span>
                    <span class="hora"><?php echo date('h:i A', strtotime($sol['hora'])); ?></span>
                </div>
                <div class="solicitud-body">
                    <h4><?php echo htmlspecialchars($sol['estudiante_apellidos'] . ', ' . $sol['estudiante_nombres']); ?></h4>
                    <p class="codigo"><?php echo htmlspecialchars($sol['estudiante_codigo']); ?> - Ciclo <?php echo $sol['estudiante_ciclo']; ?></p>
                    <div class="motivo">
                        <strong>Motivo:</strong>
                        <p><?php echo nl2br(htmlspecialchars($sol['motivo'])); ?></p>
                    </div>
                </div>
                <div class="solicitud-actions">
                    <a href="index.php?c=consejeria&a=aprobar&id=<?php echo $sol['id']; ?>" 
                       class="btn btn-success"
                       onclick="return confirm('¿Confirmar esta solicitud de consejería?')">
                        ✅ Aprobar
                    </a>
                    <button type="button" class="btn btn-danger" 
                            onclick="mostrarRechazo(<?php echo $sol['id']; ?>)">
                        ❌ Rechazar
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">✅</div>
            <h3>No hay solicitudes pendientes</h3>
            <p>Todas las solicitudes han sido atendidas.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de rechazo -->
<div id="modal-rechazo" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Rechazar Solicitud</h3>
        <form id="form-rechazo" method="POST">
            <div class="form-group">
                <label>Motivo del rechazo:</label>
                <textarea name="motivo" rows="3" required placeholder="Ingrese el motivo del rechazo..."></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Confirmar Rechazo</button>
                <button type="button" class="btn" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<style>
.solicitudes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}
.solicitud-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}
.solicitud-header {
    background: #9b59b6;
    color: white;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
}
.solicitud-body {
    padding: 1.5rem;
}
.solicitud-body h4 {
    margin: 0 0 0.25rem;
    color: #2c3e50;
}
.solicitud-body .codigo {
    color: #7f8c8d;
    margin: 0 0 1rem;
}
.solicitud-body .motivo {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}
.solicitud-body .motivo p {
    margin: 0.5rem 0 0;
}
.solicitud-actions {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eee;
    display: flex;
    gap: 0.5rem;
}
.btn-success {
    background: #27ae60;
    color: white;
}
.btn-danger {
    background: #e74c3c;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 12px;
}
.empty-icon { font-size: 4rem; margin-bottom: 1rem; }
.empty-state h3 { color: #2c3e50; margin-bottom: 0.5rem; }
.empty-state p { color: #7f8c8d; }

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
}
.modal-content h3 {
    margin: 0 0 1rem;
}
</style>

<script>
function mostrarRechazo(id) {
    document.getElementById('form-rechazo').action = 'index.php?c=consejeria&a=rechazar&id=' + id;
    document.getElementById('modal-rechazo').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modal-rechazo').style.display = 'none';
}
</script>

<?php require_once 'views/layout/footer.php'; ?>
