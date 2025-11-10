<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📨 Solicitudes Pendientes</h2>
    <p>Gestiona las solicitudes de tutoría de tus estudiantes</p>

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

    <?php if (!empty($solicitudes)): ?>
        <div class="solicitudes-grid">
            <?php foreach ($solicitudes as $solicitud): ?>
                <div class="solicitud-card">
                    <div class="solicitud-header">
                        <h3>👨‍🎓 <?php echo htmlspecialchars($solicitud['estudiante_apellidos'] . ', ' . $solicitud['estudiante_nombres']); ?></h3>
                        <span class="badge badge-warning">Pendiente</span>
                    </div>

                    <div class="solicitud-body">
                        <p><strong>📅 Fecha:</strong> <?php echo date('d/m/Y', strtotime($solicitud['fecha'])); ?></p>
                        <p><strong>🕐 Hora:</strong> <?php echo date('h:i A', strtotime($solicitud['hora'])); ?></p>
                        <p><strong>📚 Código:</strong> <?php echo htmlspecialchars($solicitud['estudiante_codigo']); ?></p>
                        <p><strong>📊 Ciclo:</strong> <?php echo htmlspecialchars($solicitud['estudiante_ciclo']); ?></p>
                        <p><strong>📧 Email:</strong> <?php echo htmlspecialchars($solicitud['estudiante_email']); ?></p>
                        
                        <div class="motivo-box">
                            <strong>📝 Motivo:</strong>
                            <p><?php echo nl2br(htmlspecialchars($solicitud['motivo'])); ?></p>
                        </div>
                    </div>

                    <div class="solicitud-actions">
                        <button onclick="aprobarSolicitud(<?php echo $solicitud['id']; ?>)" class="btn btn-primary">
                            ✅ Aprobar
                        </button>
                        <button onclick="rechazarSolicitud(<?php echo $solicitud['id']; ?>)" class="btn btn-danger">
                            ❌ Rechazar
                        </button>
                        <a href="index.php?c=tutoria&a=detalle&id=<?php echo $solicitud['id']; ?>" class="btn">
                            👁️ Ver Detalle
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="info-box" style="text-align: center; padding: 3rem;">
            <p style="font-size: 3rem; margin-bottom: 1rem;">✅</p>
            <p style="font-size: 1.2rem; color: #7f8c8d;">No tienes solicitudes pendientes</p>
            <a href="index.php?c=dashboard&a=docente" class="btn btn-primary" style="margin-top: 1.5rem;">
                Volver al Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
.solicitudes-grid {
    display: grid;
    gap: 1.5rem;
    margin-top: 2rem;
}

.solicitud-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #f39c12;
}

.solicitud-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.solicitud-header h3 {
    margin: 0;
    color: #2c3e50;
}

.solicitud-body p {
    margin: 0.5rem 0;
    line-height: 1.6;
}

.motivo-box {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    margin-top: 1rem;
}

.motivo-box p {
    margin-top: 0.5rem;
    color: #555;
}

.solicitud-actions {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.badge {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}
</style>

<script>
function aprobarSolicitud(id) {
    if (confirm('¿Confirmar aprobación de esta solicitud?')) {
        // Enviar formulario
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?c=tutoria&a=aprobar&id=' + id;
        document.body.appendChild(form);
        form.submit();
    }
}

function rechazarSolicitud(id) {
    const motivo = prompt('Ingresa el motivo del rechazo:');
    if (motivo !== null && motivo.trim() !== '') {
        // Enviar formulario
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?c=tutoria&a=rechazar&id=' + id;
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'motivo';
        input.value = motivo;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    } else if (motivo !== null) {
        alert('Debes ingresar un motivo para rechazar');
    }
}
</script>

<?php require_once 'views/layout/footer.php'; ?>

