<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>📅 Reporte por Periodo</h2>
        <div>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimir</button>
            <a href="index.php?c=reporte&a=index" class="btn">← Volver</a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card">
        <div class="card-header">
            <h3>Seleccionar Periodo</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="index.php" class="form-inline">
                <input type="hidden" name="c" value="reporte">
                <input type="hidden" name="a" value="periodo">
                
                <div class="form-group-inline">
                    <label for="mes">Mes:</label>
                    <select name="mes" id="mes" onchange="this.form.submit()">
                        <?php
                        $meses = [
                            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
                            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                        ];
                        foreach ($meses as $num => $nombre):
                        ?>
                            <option value="<?= $num ?>" <?= $mes == $num ? 'selected' : '' ?>>
                                <?= $nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group-inline">
                    <label for="anio">Año:</label>
                    <select name="anio" id="anio" onchange="this.form.submit()">
                        <?php
                        $anio_actual = date('Y');
                        for ($a = $anio_actual; $a >= $anio_actual - 5; $a--):
                        ?>
                            <option value="<?= $a ?>" <?= $anio == $a ? 'selected' : '' ?>>
                                <?= $a ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas del Periodo -->
    <div class="card">
        <div class="card-header">
            <h3>Resumen de <?= $meses[$mes] ?> <?= $anio ?></h3>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= $estadisticas_periodo['tutorias_total'] ?></div>
                    <div class="stat-label">Tutorías Totales</div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-number"><?= $estadisticas_periodo['tutorias_realizadas'] ?></div>
                    <div class="stat-label">Tutorías Realizadas</div>
                </div>
                <div class="stat-card stat-info">
                    <div class="stat-number"><?= $estadisticas_periodo['seguimientos_total'] ?></div>
                    <div class="stat-label">Seguimientos</div>
                </div>
                <div class="stat-card stat-warning">
                    <div class="stat-number"><?= $estadisticas_periodo['estudiantes_unicos'] ?></div>
                    <div class="stat-label">Estudiantes Atendidos</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tutorías del Periodo -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Tutorías del Periodo</h3>
        </div>
        <div class="card-body">
            <?php if (empty($tutorias_periodo)): ?>
                <div class="empty-state">
                    <p>No hay tutorías registradas en este periodo</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estudiante</th>
                                <th>Código</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tutorias_periodo as $t): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($t['fecha'])) ?></td>
                                <td><?= date('H:i', strtotime($t['hora'])) ?></td>
                                <td><?= htmlspecialchars($t['estudiante_nombres'] . ' ' . $t['estudiante_apellidos']) ?></td>
                                <td><?= htmlspecialchars($t['estudiante_codigo']) ?></td>
                                <td><?= htmlspecialchars(substr($t['motivo'], 0, 40)) ?><?= strlen($t['motivo']) > 40 ? '...' : '' ?></td>
                                <td>
                                    <?php
                                        $badge = 'badge-warning';
                                        if ($t['estado'] == 'realizada') $badge = 'badge-success';
                                        elseif ($t['estado'] == 'cancelada') $badge = 'badge-danger';
                                        elseif ($t['estado'] == 'confirmada') $badge = 'badge-info';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($t['estado']) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Seguimientos del Periodo -->
    <div class="card">
        <div class="card-header">
            <h3>📊 Seguimientos del Periodo</h3>
        </div>
        <div class="card-body">
            <?php if (empty($seguimientos_periodo)): ?>
                <div class="empty-state">
                    <p>No hay seguimientos registrados en este periodo</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estudiante</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Nivel Avance</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($seguimientos_periodo as $s): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($s['fecha'])) ?></td>
                                <td><?= htmlspecialchars($s['estudiante_nombres'] . ' ' . $s['estudiante_apellidos']) ?></td>
                                <td><?= htmlspecialchars($s['estudiante_codigo']) ?></td>
                                <td><span class="badge badge-info"><?= ucfirst($s['tipo']) ?></span></td>
                                <td><?= ucfirst($s['nivel_avance']) ?></td>
                                <td>
                                    <?= $s['requiere_atencion'] ? '<span class="badge badge-danger">⚠️ Atención</span>' : '<span class="badge badge-success">✓ Normal</span>' ?>
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

<style>
.form-inline {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.form-group-inline {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group-inline label {
    margin: 0;
    font-weight: 500;
}

.form-group-inline select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

@media print {
    .card:first-child, .page-header button, .page-header a {
        display: none;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

