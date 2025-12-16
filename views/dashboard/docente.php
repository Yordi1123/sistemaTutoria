<?php 
require_once 'models/Tutor.php';
require_once 'models/Tutoria.php';
require_once 'models/FichaTutoria.php';

// Obtener docente_id del usuario logueado
$tutorModel = new Tutor();
$tutores = $tutorModel->getAll();
$docente_id = null;

foreach ($tutores as $tutor) {
    if ($tutor['usuario_id'] == $_SESSION['user_id']) {
        $docente_id = $tutor['id'];
        $docente_info = $tutor;
        break;
    }
}

// Obtener estadísticas
$tutoriaModel = new Tutoria();
$fichaModel = new FichaTutoria();

$solicitudes_pendientes = 0;
$tutorias_hoy = [];
$proximas_tutorias = [];
$estadisticas = [];
$estudiantes_unicos = 0;
$fichas_total = 0;

if ($docente_id) {
    $solicitudes_pendientes = $tutoriaModel->countPendientes($docente_id);
    $tutorias_hoy = $tutoriaModel->getTutoriasHoyDocente($docente_id);
    $proximas_tutorias = $tutoriaModel->getProximasDocente($docente_id);
    $estadisticas = $tutoriaModel->getEstadisticasDocente($docente_id);
    $estudiantes_unicos = $tutoriaModel->countEstudiantesUnicos($docente_id);
    $fichas_total = $fichaModel->countByDocente($docente_id);
}

require_once 'views/layout/header.php'; 
?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard Docente']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    
    <div class="dashboard-welcome">
        <h2>Bienvenido, <?= isset($docente_info) ? htmlspecialchars($docente_info['nombres']) : 'Docente' ?></h2>
        <p>Panel de gestión de tutorías y estudiantes</p>
    </div>

    <!-- Alertas -->
    <?php if ($solicitudes_pendientes > 0): ?>
        <div class="alert alert-warning">
            <strong>¡Atención!</strong> Tienes <?= $solicitudes_pendientes ?> solicitud<?= $solicitudes_pendientes > 1 ? 'es' : '' ?> de tutoría pendiente<?= $solicitudes_pendientes > 1 ? 's' : '' ?>.
            <a href="index.php?c=tutoria&a=solicitudes" style="color: #856404; text-decoration: underline;">Ver solicitudes →</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($tutorias_hoy)): ?>
        <div class="alert alert-info">
            <strong>📅 Hoy:</strong> Tienes <?= count($tutorias_hoy) ?> tutoría<?= count($tutorias_hoy) > 1 ? 's' : '' ?> programada<?= count($tutorias_hoy) > 1 ? 's' : '' ?> para hoy.
        </div>
    <?php endif; ?>

    <!-- Estadísticas del Docente -->
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
                <p>Tutorías Realizadas</p>
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
            
            <a href="index.php?c=tutoria&a=solicitudes" class="action-card">
                <div class="action-icon">📩</div>
                <h4>Solicitudes</h4>
                <p>Atender solicitudes de tutoría</p>
                <?php if ($solicitudes_pendientes > 0): ?>
                    <span class="badge badge-warning"><?= $solicitudes_pendientes ?></span>
                <?php endif; ?>
            </a>

            <a href="index.php?c=tutoria&a=mistutoriasdocente" class="action-card">
                <div class="action-icon">📅</div>
                <h4>Mis Tutorías</h4>
                <p>Ver y gestionar tutorías programadas</p>
            </a>

            <a href="index.php?c=horario&a=index" class="action-card">
                <div class="action-icon">⏰</div>
                <h4>Mis Horarios</h4>
                <p>Gestionar disponibilidad horaria</p>
            </a>

            <a href="index.php?c=ficha&a=misfichas" class="action-card">
                <div class="action-icon">📝</div>
                <h4>Mis Fichas</h4>
                <p>Ver y llenar fichas de tutoría</p>
            </a>

            <a href="index.php?c=seguimiento&a=estudiantes" class="action-card">
                <div class="action-icon">📊</div>
                <h4>Seguimiento</h4>
                <p>Registrar seguimiento de estudiantes</p>
            </a>

            <a href="index.php?c=reporte&a=index" class="action-card">
                <div class="action-icon">📈</div>
                <h4>Reportes</h4>
                <p>Ver estadísticas y reportes</p>
            </a>

            <a href="index.php?c=estudiante" class="action-card">
                <div class="action-icon">👨‍🎓</div>
                <h4>Estudiantes</h4>
                <p>Consultar lista de estudiantes</p>
            </a>

            <a href="index.php?c=asignacion&a=misAsignados" class="action-card">
                <div class="action-icon">📌</div>
                <h4>Mis Asignados</h4>
                <p>Ver estudiantes asignados permanentemente</p>
            </a>

        </div>
    </div>

    <!-- Tutorías de Hoy -->
    <?php if (!empty($tutorias_hoy)): ?>
    <div class="dashboard-section">
        <h3>Tutorías de Hoy</h3>
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
                    <?php foreach ($tutorias_hoy as $tutoria): ?>
                    <tr>
                        <td><strong><?= date('H:i', strtotime($tutoria['hora'])) ?></strong></td>
                        <td><?= htmlspecialchars($tutoria['estudiante_nombres'] . ' ' . $tutoria['estudiante_apellidos']) ?></td>
                        <td><?= htmlspecialchars(substr($tutoria['motivo'], 0, 50)) ?><?= strlen($tutoria['motivo']) > 50 ? '...' : '' ?></td>
                        <td>
                            <?php
                                $badge_class = 'badge-warning';
                                if ($tutoria['estado'] == 'realizada') $badge_class = 'badge-success';
                                elseif ($tutoria['estado'] == 'cancelada') $badge_class = 'badge-danger';
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= ucfirst($tutoria['estado']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?c=tutoria&a=detalle&id=<?= $tutoria['id'] ?>" 
                               class="btn btn-sm btn-primary">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Próximas Tutorías -->
    <div class="dashboard-section">
        <h3>Próximas Tutorías</h3>
        <?php if (empty($proximas_tutorias)): ?>
            <div class="info-box">
                <p class="text-muted">No hay tutorías programadas próximamente</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estudiante</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($proximas_tutorias, 0, 5) as $tutoria): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($tutoria['fecha'])) ?></td>
                            <td><?= date('H:i', strtotime($tutoria['hora'])) ?></td>
                            <td><?= htmlspecialchars($tutoria['estudiante_nombres'] . ' ' . $tutoria['estudiante_apellidos']) ?></td>
                            <td><?= htmlspecialchars(substr($tutoria['motivo'], 0, 40)) ?><?= strlen($tutoria['motivo']) > 40 ? '...' : '' ?></td>
                            <td>
                                <span class="badge badge-info">
                                    <?= ucfirst($tutoria['estado']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (count($proximas_tutorias) > 5): ?>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="index.php?c=tutoria&a=mistutoriasdocente" class="btn btn-secondary">
                        Ver todas las tutorías (<?= count($proximas_tutorias) ?>)
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>

<?php require_once 'views/layout/footer.php'; ?>

