<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>📈 Reporte General</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir</button>
            <a href="index.php?c=reporte&a=index" class="btn">← Volver</a>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($tutorias) ?></div>
            <div class="stat-label">Total Tutorías</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $estadisticas['realizadas'] ?? 0 ?></div>
            <div class="stat-label">Realizadas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($fichas) ?></div>
            <div class="stat-label">Fichas Elaboradas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($seguimientos) ?></div>
            <div class="stat-label">Seguimientos</div>
        </div>
    </div>

    <!-- Tutorías por mes -->
    <?php if (!empty($tutorias_por_mes)): ?>
    <div class="card">
        <div class="card-header">
            <h3>📅 Tutorías por Mes</h3>
        </div>
        <div class="card-body">
            <div class="chart-simple">
                <?php 
                arsort($tutorias_por_mes);
                $max = max($tutorias_por_mes);
                foreach ($tutorias_por_mes as $mes => $cantidad): 
                    $porcentaje = ($cantidad / $max) * 100;
                    $fecha = DateTime::createFromFormat('Y-m', $mes);
                ?>
                    <div class="chart-row">
                        <div class="chart-label">
                            <?= $fecha ? $fecha->format('F Y') : $mes ?>
                        </div>
                        <div class="chart-bar-container">
                            <div class="chart-bar" style="width: <?= $porcentaje ?>%"></div>
                            <span class="chart-value"><?= $cantidad ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Resumen de Tutorías -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Resumen de Tutorías</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estudiante</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Ficha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($tutorias, 0, 20) as $t): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($t['fecha'])) ?></td>
                            <td><?= htmlspecialchars($t['estudiante_nombres'] . ' ' . $t['estudiante_apellidos']) ?></td>
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
                                            $tiene_ficha = true;
                                            break;
                                        }
                                    }
                                ?>
                                <?= $tiene_ficha ? '✅' : '❌' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (count($tutorias) > 20): ?>
                <p class="text-muted text-center">Mostrando 20 de <?= count($tutorias) ?> tutorías</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Resumen de Seguimientos -->
    <div class="card">
        <div class="card-header">
            <h3>📊 Resumen de Seguimientos</h3>
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
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($seguimientos, 0, 20) as $s): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($s['fecha'])) ?></td>
                            <td><?= htmlspecialchars($s['estudiante_nombres'] . ' ' . $s['estudiante_apellidos']) ?></td>
                            <td><span class="badge badge-info"><?= ucfirst($s['tipo']) ?></span></td>
                            <td><?= ucfirst($s['nivel_avance']) ?></td>
                            <td>
                                <?= $s['requiere_atencion'] ? '<span class="badge badge-danger">⚠️ Atención</span>' : '✅' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (count($seguimientos) > 20): ?>
                <p class="text-muted text-center">Mostrando 20 de <?= count($seguimientos) ?> seguimientos</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.chart-simple {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.chart-row {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chart-label {
    min-width: 150px;
    font-weight: 500;
}

.chart-bar-container {
    flex: 1;
    position: relative;
    height: 30px;
    background: #f0f0f0;
    border-radius: 5px;
}

.chart-bar {
    height: 100%;
    background: linear-gradient(90deg, #2c5aa0, #4a7cc7);
    border-radius: 5px;
    transition: width 0.3s;
}

.chart-value {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-weight: bold;
}

@media print {
    .page-header button, .page-header a {
        display: none;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

