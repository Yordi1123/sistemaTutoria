<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Mis Fichas de Tutoría</h2>
        <a href="index.php?c=dashboard&a=estudiante" class="btn">← Volver al Dashboard</a>
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

    <!-- Información -->
    <div class="card">
        <div class="card-header">
            <h3>ℹ️ Información</h3>
        </div>
        <div class="card-body">
            <p>Las fichas de tutoría contienen el registro detallado de cada sesión realizada, incluyendo:</p>
            <ul>
                <li>📋 Problemática identificada</li>
                <li>✅ Acciones realizadas durante la sesión</li>
                <li>💡 Conclusiones del tutor</li>
                <li>📌 Recomendaciones para tu seguimiento</li>
            </ul>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($fichas) ?></div>
            <div class="stat-label">Total de Fichas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                    $ultimas30dias = array_filter($fichas, function($f) {
                        return strtotime($f['fecha_registro']) > strtotime('-30 days');
                    });
                    echo count($ultimas30dias);
                ?>
            </div>
            <div class="stat-label">Últimos 30 días</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                    $esteMes = array_filter($fichas, function($f) {
                        return date('Y-m', strtotime($f['fecha_registro'])) == date('Y-m');
                    });
                    echo count($esteMes);
                ?>
            </div>
            <div class="stat-label">Este mes</div>
        </div>
    </div>

    <!-- Lista de fichas -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Mis Fichas Registradas</h3>
        </div>
        <div class="card-body">
            <?php if (empty($fichas)): ?>
                <div class="empty-state">
                    <p>Aún no tienes fichas de tutoría registradas</p>
                    <p class="text-muted">Las fichas son llenadas por el docente después de cada sesión de tutoría realizada.</p>
                    <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary">
                        Solicitar tutoría
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha Tutoría</th>
                                <th>Docente</th>
                                <th>Motivo</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fichas as $ficha): ?>
                            <tr>
                                <td>
                                    <strong><?= date('d/m/Y', strtotime($ficha['tutoria_fecha'])) ?></strong><br>
                                    <small><?= date('H:i', strtotime($ficha['tutoria_hora'])) ?></small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($ficha['docente_nombres'] . ' ' . $ficha['docente_apellidos']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars(substr($ficha['tutoria_motivo'], 0, 40)) ?>
                                    <?= strlen($ficha['tutoria_motivo']) > 40 ? '...' : '' ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($ficha['fecha_registro'])) ?><br>
                                    <small><?= date('H:i', strtotime($ficha['fecha_registro'])) ?></small>
                                </td>
                                <td>
                                    <a href="index.php?c=ficha&a=ver&id=<?= $ficha['id'] ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Ver ficha completa">
                                        👁️ Ver Detalle
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Acceso Rápido -->
    <div class="card">
        <div class="card-header">
            <h3>🔗 Accesos Rápidos</h3>
        </div>
        <div class="card-body">
            <div class="action-grid">
                <a href="index.php?c=tutoria&a=historial" class="action-card">
                    <div class="action-icon">📊</div>
                    <h4>Mi Historial</h4>
                    <p>Ver todas mis tutorías</p>
                </a>

                <a href="index.php?c=tutoria&a=mistutorias" class="action-card">
                    <div class="action-icon">📅</div>
                    <h4>Mis Tutorías</h4>
                    <p>Ver tutorías programadas</p>
                </a>

                <a href="index.php?c=tutoria&a=solicitar" class="action-card">
                    <div class="action-icon">📝</div>
                    <h4>Nueva Tutoría</h4>
                    <p>Solicitar otra sesión</p>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

