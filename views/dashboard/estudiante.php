<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Sistema de Tutoría</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    
    <!-- Navbar -->
    <header class="dashboard-header">
        <nav>
            <div class="nav-brand">
                <h1>🎓 Sistema de Tutoría</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php?c=dashboard&a=estudiante" class="active">Dashboard</a></li>
                <li><a href="index.php?c=tutor">Ver Tutores</a></li>
                <li><a href="index.php?c=tutoria&a=mistutorias">Mis Tutorías</a></li>
                <li class="nav-user">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?> (Estudiante)</span>
                    <a href="index.php?c=auth&a=logout" class="btn btn-small btn-danger">Salir</a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-main">
        <div class="container">
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="dashboard-welcome">
                <h2>Bienvenido, Estudiante</h2>
                <p>Gestiona tus tutorías y aprovecha al máximo tu aprendizaje</p>
            </div>

            <!-- Estadísticas del Estudiante -->
            <div class="stats-grid">
                
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['pendientes'] + $estadisticas['confirmadas']; ?></h3>
                        <p>Tutorías Pendientes</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['realizadas']; ?></h3>
                        <p>Tutorías Realizadas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <h3><?php echo count($tutoriasHoy); ?></h3>
                        <p>Tutorías Hoy</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <div class="stat-content">
                        <h3><?php echo $estadisticas['total']; ?></h3>
                        <p>Total de Tutorías</p>
                    </div>
                </div>

            </div>

            <!-- Tutorías de Hoy -->
            <?php if (!empty($tutoriasHoy)): ?>
            <div class="dashboard-section">
                <h3>🔥 Tutorías de Hoy</h3>
                <div class="alert" style="background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;">
                    <strong>¡Importante!</strong> Tienes <?php echo count($tutoriasHoy); ?> tutoría(s) programada(s) para hoy.
                    <a href="index.php?c=tutoria&a=asistencia" class="btn btn-primary" style="margin-left: 1rem;">
                        Ver y Confirmar Asistencia
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Acciones Rápidas -->
            <div class="dashboard-section">
                <h3>Acciones Rápidas</h3>
                <div class="action-grid">
                    
                    <a href="index.php?c=tutoria&a=solicitar" class="action-card">
                        <div class="action-icon">📝</div>
                        <h4>Solicitar Tutoría</h4>
                        <p>Agenda una sesión con un tutor</p>
                    </a>

                    <a href="index.php?c=tutoria&a=asistencia" class="action-card">
                        <div class="action-icon">✅</div>
                        <h4>Confirmar Asistencia</h4>
                        <p>Confirma tu asistencia a tutorías de hoy</p>
                    </a>

                    <a href="index.php?c=tutor" class="action-card">
                        <div class="action-icon">👨‍🏫</div>
                        <h4>Ver Tutores</h4>
                        <p>Consulta la lista de tutores disponibles</p>
                    </a>

                    <a href="index.php?c=tutoria&a=historial" class="action-card">
                        <div class="action-icon">📊</div>
                        <h4>Mi Historial</h4>
                        <p>Ver tutorías y estadísticas</p>
                    </a>

                </div>
            </div>

            <!-- Próximas Tutorías -->
            <div class="dashboard-section">
                <h3>📅 Próximas Tutorías</h3>
                <?php if (!empty($proximasTutorias)): ?>
                    <div class="proximas-tutorias">
                        <?php foreach ($proximasTutorias as $tutoria): ?>
                            <div class="tutoria-item">
                                <div class="tutoria-fecha">
                                    <strong><?php echo date('d', strtotime($tutoria['fecha'])); ?></strong>
                                    <span><?php echo date('M', strtotime($tutoria['fecha'])); ?></span>
                                </div>
                                <div class="tutoria-info">
                                    <h4><?php echo date('h:i A', strtotime($tutoria['hora'])); ?> - 
                                        <?php echo htmlspecialchars($tutoria['tutor_apellidos'] . ', ' . $tutoria['tutor_nombres']); ?>
                                    </h4>
                                    <p><?php echo htmlspecialchars($tutoria['tutor_especialidad']); ?></p>
                                    <small><?php echo htmlspecialchars(substr($tutoria['motivo'], 0, 60)) . '...'; ?></small>
                                </div>
                                <div class="tutoria-estado">
                                    <span class="badge badge-<?php echo $tutoria['estado'] == 'confirmada' ? 'info' : 'warning'; ?>">
                                        <?php echo ucfirst($tutoria['estado']); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="info-box">
                        <p class="text-muted">No tienes tutorías programadas próximamente</p>
                        <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary">Solicitar Tutoría</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Avisos -->
            <div class="dashboard-section">
                <h3>📌 Avisos</h3>
                <div class="info-box">
                    <p>✅ Bienvenido al sistema de tutoría UNS</p>
                    <p>📅 Recuerda programar tus tutorías con anticipación</p>
                    <p>⏰ Confirma tu asistencia el día de la tutoría</p>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> - Sistema de Tutoría UNS</p>
    </footer>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>

<style>
.proximas-tutorias {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.tutoria-item {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.tutoria-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.tutoria-fecha {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
    min-width: 70px;
}

.tutoria-fecha strong {
    display: block;
    font-size: 1.8rem;
    line-height: 1;
}

.tutoria-fecha span {
    display: block;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.tutoria-info {
    flex: 1;
}

.tutoria-info h4 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.tutoria-info p {
    margin: 0;
    color: #7f8c8d;
}

.tutoria-info small {
    color: #95a5a6;
}

.tutoria-estado {
    min-width: 100px;
    text-align: right;
}

.badge {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}

.badge-info {
    background: #cfe2ff;
    color: #084298;
}

@media (max-width: 768px) {
    .tutoria-item {
        flex-direction: column;
        text-align: center;
    }
    
    .tutoria-estado {
        text-align: center;
    }
}
</style>
