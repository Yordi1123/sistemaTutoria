<?php 
require_once 'views/layout/header.php'; 
?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard Consejero']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    
    <div class="dashboard-welcome">
        <h2>Bienvenido, <?= isset($consejero) ? htmlspecialchars($consejero['nombres']) : 'Consejero' ?></h2>
        <p>Panel de gestión de consejerías y atención estudiantil</p>
    </div>

    <!-- Alertas -->
    <?php if ($solicitudes_pendientes > 0): ?>
        <div class="alert alert-warning">
            <strong>¡Atención!</strong> Tienes <?= $solicitudes_pendientes ?> solicitud<?= $solicitudes_pendientes > 1 ? 'es' : '' ?> de consejería pendiente<?= $solicitudes_pendientes > 1 ? 's' : '' ?>.
            <a href="index.php?c=consejeria&a=solicitudes" style="color: #856404; text-decoration: underline;">Ver solicitudes →</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($consejerias_hoy)): ?>
        <div class="alert alert-info">
            <strong>📅 Hoy:</strong> Tienes <?= count($consejerias_hoy) ?> consejería<?= count($consejerias_hoy) > 1 ? 's' : '' ?> programada<?= count($consejerias_hoy) > 1 ? 's' : '' ?> para hoy.
        </div>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="stats-grid">
        
        <div class="stat-card stat-warning">
            <div class="stat-icon">📩</div>
            <div class="stat-content">
                <h3><?= $solicitudes_pendientes ?></h3>
                <p>Solicitudes Pendientes</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?= $estadisticas['realizadas'] ?? 0 ?></h3>
                <p>Consejerías Realizadas</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">👨‍🎓</div>
            <div class="stat-content">
                <h3><?= $estudiantes_unicos ?></h3>
                <p>Estudiantes Atendidos</p>
            </div>
        </div>

        <div class="stat-card stat-primary">
            <div class="stat-icon">📝</div>
            <div class="stat-content">
                <h3><?= $fichas_total ?></h3>
                <p>Fichas Registradas</p>
            </div>
        </div>

    </div>

    <!-- Acciones Rápidas -->
    <div class="dashboard-section">
        <h3>Acciones Rápidas</h3>
        <div class="action-grid">
            
            <a href="index.php?c=consejeria&a=solicitudes" class="action-card">
                <div class="action-icon">📩</div>
                <h4>Solicitudes</h4>
                <p>Atender solicitudes de consejería</p>
                <?php if ($solicitudes_pendientes > 0): ?>
                    <span class="badge badge-warning"><?= $solicitudes_pendientes ?></span>
                <?php endif; ?>
            </a>

            <a href="index.php?c=consejeria&a=index" class="action-card">
                <div class="action-icon">📅</div>
                <h4>Mis Consejerías</h4>
                <p>Ver y gestionar consejerías programadas</p>
            </a>

            <a href="index.php?c=consejeria&a=misFichas" class="action-card">
                <div class="action-icon">📝</div>
                <h4>Mis Fichas</h4>
                <p>Ver y crear fichas de consejería</p>
            </a>

            <a href="index.php?c=estudiante" class="action-card">
                <div class="action-icon">👨‍🎓</div>
                <h4>Estudiantes</h4>
                <p>Consultar lista de estudiantes</p>
            </a>

        </div>
    </div>

    <!-- Consejerías de Hoy -->
    <?php if (!empty($consejerias_hoy)): ?>
    <div class="dashboard-section">
        <h3>Consejerías de Hoy</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Estudiante</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consejerias_hoy as $consejeria): ?>
                    <tr>
                        <td><strong><?= date('H:i', strtotime($consejeria['hora'])) ?></strong></td>
                        <td><?= htmlspecialchars($consejeria['estudiante_nombres'] . ' ' . $consejeria['estudiante_apellidos']) ?></td>
                        <td><?= htmlspecialchars(substr($consejeria['motivo'], 0, 50)) ?><?= strlen($consejeria['motivo']) > 50 ? '...' : '' ?></td>
                        <td>
                            <span class="badge badge-info"><?= ucfirst($consejeria['estado']) ?></span>
                        </td>
                        <td>
                            <a href="index.php?c=consejeria&a=detalle&id=<?= $consejeria['id'] ?>" class="btn btn-sm btn-primary">Ver detalle</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.stat-icon { font-size: 2rem; }
.stat-content h3 { margin: 0; font-size: 1.5rem; color: #2c3e50; }
.stat-content p { margin: 0; color: #7f8c8d; font-size: 0.9rem; }
.stat-warning { border-left: 4px solid #f39c12; }
.stat-success { border-left: 4px solid #27ae60; }
.stat-info { border-left: 4px solid #3498db; }
.stat-primary { border-left: 4px solid #9b59b6; }

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.action-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}
.action-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
.action-card h4 { margin: 0 0 0.25rem; color: #2c3e50; }
.action-card p { margin: 0; color: #7f8c8d; font-size: 0.85rem; }
.action-card .badge {
    position: absolute;
    top: 10px;
    right: 10px;
}
.badge { padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; }
.badge-warning { background: #f39c12; color: white; }
.badge-info { background: #3498db; color: white; }
</style>

<?php require_once 'views/layout/footer.php'; ?>
