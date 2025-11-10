<?php 
require_once 'models/Estudiante.php';
require_once 'models/Tutoria.php';
require_once 'models/FichaTutoria.php';

// Obtener estudiante_id del usuario logueado
$estudianteModel = new Estudiante();
$estudiantes = $estudianteModel->getAll();
$estudiante_id = null;
$estudiante_info = null;

foreach ($estudiantes as $estudiante) {
    if ($estudiante['usuario_id'] == $_SESSION['user_id']) {
        $estudiante_id = $estudiante['id'];
        $estudiante_info = $estudiante;
        break;
    }
}

// Obtener estadísticas y datos
$tutoriaModel = new Tutoria();
$fichaModel = new FichaTutoria();

$estadisticas = ['total' => 0, 'pendientes' => 0, 'confirmadas' => 0, 'realizadas' => 0, 'canceladas' => 0];
$tutoriasHoy = [];
$proximasTutorias = [];
$fichas_total = 0;

if ($estudiante_id) {
    $estadisticas = $tutoriaModel->getEstadisticas($estudiante_id);
    $tutoriasHoy = $tutoriaModel->getTutoriasHoy($estudiante_id);
    $proximasTutorias = $tutoriaModel->getProximas($estudiante_id);
    $fichas_total = count($fichaModel->getByEstudiante($estudiante_id));
}

require_once 'views/layout/header.php'; 
?>

<div class="container">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="dashboard-welcome">
        <h2>Bienvenido, <?= isset($estudiante_info) ? htmlspecialchars($estudiante_info['nombres']) : 'Estudiante' ?></h2>
        <p>Gestiona tus tutorías y aprovecha al máximo tu aprendizaje</p>
    </div>

    <!-- Alertas -->
    <?php if (!empty($tutoriasHoy)): ?>
        <div class="alert alert-warning">
            <strong>🔥 ¡Importante!</strong> Tienes <?= count($tutoriasHoy) ?> tutoría<?= count($tutoriasHoy) > 1 ? 's' : '' ?> programada<?= count($tutoriasHoy) > 1 ? 's' : '' ?> para hoy.
            <a href="index.php?c=tutoria&a=asistencia" style="color: #856404; text-decoration: underline; margin-left: 10px;">
                Confirmar asistencia →
            </a>
        </div>
    <?php endif; ?>

    <!-- Estadísticas del Estudiante -->
    <div class="stats-grid">
        
        <div class="stat-card stat-warning">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <h3><?= $estadisticas['pendientes'] + $estadisticas['confirmadas'] ?></h3>
                <p>Tutorías Pendientes</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?= $estadisticas['realizadas'] ?></h3>
                <p>Tutorías Realizadas</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <h3><?= count($tutoriasHoy) ?></h3>
                <p>Tutorías Hoy</p>
            </div>
        </div>

        <div class="stat-card stat-primary">
            <div class="stat-icon">📚</div>
            <div class="stat-content">
                <h3><?= $estadisticas['total'] ?></h3>
                <p>Total de Tutorías</p>
            </div>
        </div>

    </div>

    <!-- Acciones Rápidas -->
    <div class="dashboard-section">
        <h3>Acciones Rápidas</h3>
        <div class="action-grid">
            
            <a href="index.php?c=tutoria&a=solicitar" class="action-card">
                <div class="action-icon">📝</div>
                <h4>Solicitar Tutoría</h4>
                <p>Agenda una sesión con un tutor</p>
            </a>

            <a href="index.php?c=tutoria&a=mistutorias" class="action-card">
                <div class="action-icon">📅</div>
                <h4>Mis Tutorías</h4>
                <p>Ver tutorías programadas</p>
            </a>

            <a href="index.php?c=tutoria&a=asistencia" class="action-card">
                <div class="action-icon">✅</div>
                <h4>Confirmar Asistencia</h4>
                <p>Registrar asistencia a tutorías</p>
                <?php if (!empty($tutoriasHoy)): ?>
                    <span class="badge badge-warning"><?= count($tutoriasHoy) ?></span>
                <?php endif; ?>
            </a>

            <a href="index.php?c=tutoria&a=historial" class="action-card">
                <div class="action-icon">📊</div>
                <h4>Mi Historial</h4>
                <p>Ver tutorías y estadísticas</p>
            </a>

            <a href="index.php?c=ficha&a=misfichasestudiante" class="action-card">
                <div class="action-icon">📋</div>
                <h4>Mis Fichas</h4>
                <p>Ver fichas de tutoría</p>
                <?php if ($fichas_total > 0): ?>
                    <span class="badge badge-success"><?= $fichas_total ?></span>
                <?php endif; ?>
            </a>

            <a href="index.php?c=tutor" class="action-card">
                <div class="action-icon">👨‍🏫</div>
                <h4>Ver Tutores</h4>
                <p>Consultar lista de tutores</p>
            </a>

        </div>
    </div>

    <!-- Próximas Tutorías -->
    <div class="dashboard-section">
        <h3>📅 Próximas Tutorías</h3>
        <?php if (empty($proximasTutorias)): ?>
            <div class="info-box">
                <p class="text-muted">No tienes tutorías programadas próximamente</p>
                <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary">Solicitar Tutoría</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Docente</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($proximasTutorias, 0, 5) as $tutoria): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($tutoria['fecha'])) ?></td>
                            <td><?= date('H:i', strtotime($tutoria['hora'])) ?></td>
                            <td><?= htmlspecialchars($tutoria['tutor_nombres'] . ' ' . $tutoria['tutor_apellidos']) ?></td>
                            <td><?= htmlspecialchars($tutoria['tutor_especialidad']) ?></td>
                            <td>
                                <?php
                                    $badge_class = 'badge-warning';
                                    if ($tutoria['estado'] == 'confirmada') $badge_class = 'badge-info';
                                    elseif ($tutoria['estado'] == 'realizada') $badge_class = 'badge-success';
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
            <?php if (count($proximasTutorias) > 5): ?>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="index.php?c=tutoria&a=mistutorias" class="btn btn-secondary">
                        Ver todas las tutorías (<?= count($proximasTutorias) ?>)
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Recursos Útiles -->
    <div class="dashboard-section">
        <h3>💡 Recursos Útiles</h3>
        <div class="info-box">
            <ul style="margin: 0; padding-left: 20px;">
                <li>📝 Solicita tus tutorías con anticipación para mejor disponibilidad</li>
                <li>⏰ Confirma tu asistencia el día de la tutoría para mantener tu sesión</li>
                <li>📋 Revisa tus fichas de tutoría para conocer tu progreso</li>
                <li>📊 Consulta tu historial para ver estadísticas completas</li>
                <li>👨‍🏫 Explora la lista de tutores para conocer sus especialidades</li>
            </ul>
        </div>
    </div>

</div>

<?php require_once 'views/layout/footer.php'; ?>
