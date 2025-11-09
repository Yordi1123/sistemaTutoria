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
                <li class="nav-user">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?> (Estudiante)</span>
                    <a href="index.php?c=auth&a=logout" class="btn btn-small btn-danger">Salir</a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-main">
        <div class="container">
            
            <div class="dashboard-welcome">
                <h2>Bienvenido, Estudiante</h2>
                <p>Gestiona tus tutorías y consejerías</p>
            </div>

            <!-- Estadísticas del Estudiante -->
            <div class="stats-grid">
                
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Tutorías Pendientes</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Tutorías Completadas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💬</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Consejerías</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Horas de Tutoría</p>
                    </div>
                </div>

            </div>

            <!-- Acciones Rápidas -->
            <div class="dashboard-section">
                <h3>Acciones Rápidas</h3>
                <div class="action-grid">
                    
                    <a href="#" class="action-card">
                        <div class="action-icon">📅</div>
                        <h4>Solicitar Tutoría</h4>
                        <p>Agenda una sesión con un tutor</p>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">💬</div>
                        <h4>Solicitar Consejería</h4>
                        <p>Solicita orientación académica</p>
                    </a>

                    <a href="index.php?c=tutor" class="action-card">
                        <div class="action-icon">👨‍🏫</div>
                        <h4>Ver Tutores</h4>
                        <p>Consulta la lista de tutores</p>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">📊</div>
                        <h4>Mi Historial</h4>
                        <p>Ver tutorías y consejerías pasadas</p>
                    </a>

                </div>
            </div>

            <!-- Próximas Citas -->
            <div class="dashboard-section">
                <h3>Próximas Citas</h3>
                <div class="info-box">
                    <p class="text-muted">No tienes citas programadas próximamente</p>
                    <a href="#" class="btn btn-primary">Solicitar Tutoría</a>
                </div>
            </div>

            <!-- Avisos -->
            <div class="dashboard-section">
                <h3>Avisos y Notificaciones</h3>
                <div class="info-box">
                    <p>✅ Bienvenido al sistema de tutoría UNS</p>
                    <p>📌 Recuerda programar tus tutorías con anticipación</p>
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

