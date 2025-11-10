<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Reporte de Estudiante</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir</button>
            <a href="javascript:history.back()" class="btn">← Volver</a>
        </div>
    </div>

    <!-- Información del Estudiante -->
    <div class="card">
        <div class="card-header">
            <h3>Información Personal</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Nombre Completo:</strong> 
                    <?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Código:</strong> <?= htmlspecialchars($estudiante['codigo']) ?>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <?= htmlspecialchars($estudiante['email']) ?>
                </div>
                <div class="info-item">
                    <strong>Escuela:</strong> <?= htmlspecialchars($estudiante['escuela']) ?>
                </div>
                <div class="info-item">
                    <strong>Ciclo:</strong> <?= $estudiante['ciclo'] ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Estudiante -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($tutorias) ?></div>
            <div class="stat-label">Total Tutorías</div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-number"><?= $estadisticas_est['realizadas'] ?? 0 ?></div>
            <div class="stat-label">Tutorías Realizadas</div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-number"><?= count($fichas) ?></div>
            <div class="stat-label">Fichas de Tutoría</div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-number"><?= count($seguimientos) ?></div>
            <div class="stat-label">Seguimientos</div>
        </div>
    </div>

    <!-- Historial de Tutorías -->
    <div class="card">
        <div class="card-header">
            <h3>📅 Historial de Tutorías</h3>
        </div>
        <div class="card-body">
            <?php if (empty($tutorias)): ?>
                <div class="empty-state">
                    <p>No hay tutorías registradas</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Docente</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Ficha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tutorias as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($t['fecha'])) ?></td>
                                <td><?= date('H:i', strtotime($t['hora'])) ?></td>
                                <td><?= htmlspecialchars($t['docente_nombres'] . ' ' . $t['docente_apellidos']) ?></td>
                                <td><?= htmlspecialchars(substr($t['motivo'], 0, 50)) ?><?= strlen($t['motivo']) > 50 ? '...' : '' ?></td>
                                <td>
                                    <?php
                                        $badge = 'badge-warning';
                                        if ($t['estado'] == 'realizada') $badge = 'badge-success';
                                        elseif ($t['estado'] == 'cancelada') $badge = 'badge-danger';
                                        elseif ($t['estado'] == 'confirmada') $badge = 'badge-info';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($t['estado']) ?></span>
                                </td>
                                <td>
                                    <?php
                                        $tiene_ficha = false;
                                        foreach ($fichas as $f) {
                                            if ($f['tutoria_id'] == $t['id']) {
                                                echo '<a href="index.php?c=ficha&a=ver&id=' . $f['id'] . '" class="btn btn-sm btn-primary">Ver</a>';
                                                $tiene_ficha = true;
                                                break;
                                            }
                                        }
                                        if (!$tiene_ficha) echo '<span class="text-muted">-</span>';
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Historial de Seguimientos -->
    <div class="card">
        <div class="card-header">
            <h3>📊 Historial de Seguimientos</h3>
        </div>
        <div class="card-body">
            <?php if (empty($seguimientos)): ?>
                <div class="empty-state">
                    <p>No hay seguimientos registrados</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Docente</th>
                                <th>Tipo</th>
                                <th>Estado Ánimo</th>
                                <th>Nivel Avance</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($seguimientos as $s): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($s['fecha'])) ?></td>
                                <td><?= htmlspecialchars($s['docente_nombres'] . ' ' . $s['docente_apellidos']) ?></td>
                                <td><span class="badge badge-info"><?= ucfirst($s['tipo']) ?></span></td>
                                <td><?= str_replace('_', ' ', $s['estado_animo']) ?></td>
                                <td>
                                    <?php
                                        $badge = 'badge-warning';
                                        if ($s['nivel_avance'] == 'destacado') $badge = 'badge-success';
                                        elseif ($s['nivel_avance'] == 'deficiente') $badge = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($s['nivel_avance']) ?></span>
                                </td>
                                <td><?= htmlspecialchars(substr($s['observaciones'], 0, 60)) ?><?= strlen($s['observaciones']) > 60 ? '...' : '' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Evolución -->
    <?php if (!empty($evolucion)): ?>
    <div class="card">
        <div class="card-header">
            <h3>📈 Evolución del Estudiante</h3>
        </div>
        <div class="card-body">
            <div class="evolucion-timeline">
                <?php foreach ($evolucion as $e): ?>
                <div class="evolucion-item">
                    <div class="evolucion-fecha"><?= date('d/m/Y', strtotime($e['fecha'])) ?></div>
                    <div class="evolucion-info">
                        <span class="badge badge-<?= $e['nivel_avance'] == 'destacado' ? 'success' : ($e['nivel_avance'] == 'deficiente' ? 'danger' : 'warning') ?>">
                            <?= ucfirst($e['nivel_avance']) ?>
                        </span>
                        <span class="text-muted">Estado: <?= str_replace('_', ' ', $e['estado_animo']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.evolucion-timeline {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.evolucion-item {
    display: flex;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
    align-items: center;
}

.evolucion-fecha {
    min-width: 100px;
    font-weight: 500;
}

.evolucion-info {
    display: flex;
    gap: 15px;
    align-items: center;
}

@media print {
    .page-header button, .page-header a {
        display: none;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

