<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Mis Seguimientos</h2>
        <div>
            <a href="index.php?c=seguimiento&a=estudiantes" class="btn btn-primary">➕ Nuevo Seguimiento</a>
            <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($seguimientos) ?></div>
            <div class="stat-label">Total Seguimientos</div>
        </div>
        <div class="stat-card stat-danger">
            <div class="stat-number"><?= count($requierenAtencion) ?></div>
            <div class="stat-label">Requieren Atención</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                    $este_mes = array_filter($seguimientos, function($s) {
                        return date('Y-m', strtotime($s['fecha'])) == date('Y-m');
                    });
                    echo count($este_mes);
                ?>
            </div>
            <div class="stat-label">Este Mes</div>
        </div>
    </div>

    <!-- Casos que requieren atención -->
    <?php if (!empty($requierenAtencion)): ?>
    <div class="alert alert-warning">
        <strong>⚠️ Atención:</strong> Hay <?= count($requierenAtencion) ?> caso<?= count($requierenAtencion) > 1 ? 's' : '' ?> que require<?= count($requierenAtencion) > 1 ? 'n' : '' ?> seguimiento prioritario.
    </div>

    <div class="card">
        <div class="card-header">
            <h3>⚠️ Casos Prioritarios</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estudiante</th>
                            <th>Tipo</th>
                            <th>Nivel Avance</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requierenAtencion as $seg): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($seg['fecha'])) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($seg['estudiante_nombres'] . ' ' . $seg['estudiante_apellidos']) ?></strong><br>
                                <small><?= htmlspecialchars($seg['estudiante_codigo']) ?></small>
                            </td>
                            <td><span class="badge badge-info"><?= ucfirst($seg['tipo']) ?></span></td>
                            <td>
                                <?php
                                    $badge_class = 'badge-warning';
                                    if ($seg['nivel_avance'] == 'destacado') $badge_class = 'badge-success';
                                    elseif ($seg['nivel_avance'] == 'deficiente') $badge_class = 'badge-danger';
                                ?>
                                <span class="badge <?= $badge_class ?>">
                                    <?= ucfirst($seg['nivel_avance']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?c=seguimiento&a=ver&id=<?= $seg['estudiante_id'] ?>" 
                                   class="btn btn-sm btn-primary">Ver historial</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Todos los seguimientos -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Historial Completo</h3>
        </div>
        <div class="card-body">
            <?php if (empty($seguimientos)): ?>
                <div class="empty-state">
                    <p>No has registrado seguimientos</p>
                    <a href="index.php?c=seguimiento&a=estudiantes" class="btn btn-primary">
                        ➕ Registrar primer seguimiento
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estudiante</th>
                                <th>Tipo</th>
                                <th>Estado Ánimo</th>
                                <th>Nivel Avance</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($seguimientos as $seg): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($seg['fecha'])) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($seg['estudiante_nombres'] . ' ' . $seg['estudiante_apellidos']) ?></strong><br>
                                    <small><?= htmlspecialchars($seg['estudiante_codigo']) ?></small>
                                </td>
                                <td><span class="badge badge-info"><?= ucfirst($seg['tipo']) ?></span></td>
                                <td><?= str_replace('_', ' ', $seg['estado_animo']) ?></td>
                                <td>
                                    <?php
                                        $badge_class = 'badge-warning';
                                        if ($seg['nivel_avance'] == 'destacado') $badge_class = 'badge-success';
                                        elseif ($seg['nivel_avance'] == 'deficiente') $badge_class = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge_class ?>">
                                        <?= ucfirst($seg['nivel_avance']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($seg['requiere_atencion']): ?>
                                        <span class="badge badge-danger">⚠️ Atención</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">✓ Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?c=seguimiento&a=ver&id=<?= $seg['estudiante_id'] ?>" 
                                       class="btn btn-sm btn-primary">Ver historial</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

