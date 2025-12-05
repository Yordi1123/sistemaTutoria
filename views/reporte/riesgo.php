<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>⚠️ Reporte de Estudiantes en Riesgo</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir</button>
            <a href="index.php?c=reporte&a=index" class="btn">← Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Listado de Casos Prioritarios</h3>
        </div>
        <div class="card-body">
            <?php if (empty($casos_riesgo)): ?>
                <div class="empty-state">
                    <div class="empty-icon">✅</div>
                    <h3>No hay casos de riesgo detectados</h3>
                    <p>No se encontraron seguimientos que requieran atención inmediata.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha Detectada</th>
                                <th>Estudiante</th>
                                <th>Código</th>
                                <th>Tipo de Riesgo</th>
                                <th>Nivel Avance</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($casos_riesgo as $caso): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($caso['fecha'])) ?></td>
                                <td>
                                    <div class="student-info">
                                        <span class="student-name"><?= htmlspecialchars($caso['estudiante_nombres'] . ' ' . $caso['estudiante_apellidos']) ?></span>
                                        <span class="student-email"><?= htmlspecialchars($caso['estudiante_email']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($caso['estudiante_codigo']) ?></td>
                                <td>
                                    <span class="badge badge-danger"><?= ucfirst($caso['tipo']) ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-warning"><?= ucfirst($caso['nivel_avance']) ?></span>
                                </td>
                                <td>
                                    <div class="observation-text">
                                        <?= htmlspecialchars(substr($caso['observaciones'], 0, 100)) ?>
                                        <?= strlen($caso['observaciones']) > 100 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="index.php?c=seguimiento&a=estudiantes&id=<?= $caso['estudiante_id'] ?>" class="btn btn-sm btn-info">Ver Historial</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-warning mt-3">
                    <strong>Nota:</strong> Este reporte muestra todos los seguimientos marcados como "Requiere Atención". Un estudiante puede aparecer múltiples veces si tiene varios incidentes reportados.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.student-info {
    display: flex;
    flex-direction: column;
}

.student-name {
    font-weight: 500;
}

.student-email {
    font-size: 0.85rem;
    color: #666;
}

.observation-text {
    max-width: 300px;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 40px;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

@media print {
    .page-header button, .page-header a, .btn {
        display: none;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
