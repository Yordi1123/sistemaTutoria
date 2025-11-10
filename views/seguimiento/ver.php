<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Seguimiento de <?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></h2>
        <div>
            <a href="index.php?c=seguimiento&a=crear&id=<?= $estudiante['id'] ?>" class="btn btn-primary">
                ➕ Nuevo Seguimiento
            </a>
            <a href="index.php?c=seguimiento&a=estudiantes" class="btn">← Volver</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Información del estudiante -->
    <div class="card">
        <div class="card-header">
            <h3>Información del Estudiante</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Código:</strong> <?= htmlspecialchars($estudiante['codigo']) ?>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <?= htmlspecialchars($estudiante['email']) ?>
                </div>
                <div class="info-item">
                    <strong>Ciclo:</strong> <?= $estudiante['ciclo'] ?>
                </div>
                <div class="info-item">
                    <strong>Escuela:</strong> <?= htmlspecialchars($estudiante['escuela']) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de seguimientos -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Historial de Seguimientos (<?= count($seguimientos) ?>)</h3>
        </div>
        <div class="card-body">
            <?php if (empty($seguimientos)): ?>
                <div class="empty-state">
                    <p>No hay seguimientos registrados para este estudiante</p>
                    <a href="index.php?c=seguimiento&a=crear&id=<?= $estudiante['id'] ?>" class="btn btn-primary">
                        ➕ Crear primer seguimiento
                    </a>
                </div>
            <?php else: ?>
                <div class="seguimientos-timeline">
                    <?php foreach ($seguimientos as $seg): ?>
                    <div class="seguimiento-card <?= $seg['requiere_atencion'] ? 'requiere-atencion' : '' ?>">
                        <div class="seguimiento-header">
                            <div>
                                <strong><?= date('d/m/Y', strtotime($seg['fecha'])) ?></strong>
                                <span class="badge badge-info"><?= ucfirst($seg['tipo']) ?></span>
                                <?php if ($seg['requiere_atencion']): ?>
                                    <span class="badge badge-danger">⚠️ Requiere atención</span>
                                <?php endif; ?>
                            </div>
                            <div class="seguimiento-acciones">
                                <a href="index.php?c=seguimiento&a=editar&id=<?= $seg['id'] ?>" 
                                   class="btn btn-sm btn-primary">✏️ Editar</a>
                                <a href="index.php?c=seguimiento&a=eliminar&id=<?= $seg['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Eliminar este seguimiento?')">🗑️ Eliminar</a>
                            </div>
                        </div>
                        
                        <div class="seguimiento-info">
                            <div class="info-badges">
                                <span class="mini-badge">
                                    Estado: <strong><?= str_replace('_', ' ', $seg['estado_animo']) ?></strong>
                                </span>
                                <span class="mini-badge">
                                    Avance: <strong><?= ucfirst($seg['nivel_avance']) ?></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="seguimiento-content">
                            <div class="content-section">
                                <strong>Observaciones:</strong>
                                <p><?= nl2br(htmlspecialchars($seg['observaciones'])) ?></p>
                            </div>
                            
                            <?php if (!empty($seg['recomendaciones'])): ?>
                            <div class="content-section">
                                <strong>Recomendaciones:</strong>
                                <p><?= nl2br(htmlspecialchars($seg['recomendaciones'])) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="seguimiento-footer">
                            <small class="text-muted">
                                Registrado por: <?= htmlspecialchars($seg['docente_nombres'] . ' ' . $seg['docente_apellidos']) ?>
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.seguimientos-timeline {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.seguimiento-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    background: white;
}

.seguimiento-card.requiere-atencion {
    border-left: 4px solid #dc3545;
    background: #fff5f5;
}

.seguimiento-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #dee2e6;
}

.seguimiento-acciones {
    display: flex;
    gap: 5px;
}

.seguimiento-info {
    margin-bottom: 15px;
}

.info-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.mini-badge {
    background: #f8f9fa;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.875rem;
}

.content-section {
    margin-bottom: 15px;
}

.content-section strong {
    display: block;
    margin-bottom: 5px;
    color: #2c5aa0;
}

.content-section p {
    margin: 0;
    color: #666;
}

.seguimiento-footer {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

