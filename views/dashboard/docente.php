<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Docente - Sistema de Tutoría</title>
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
                <li><a href="index.php?c=dashboard&a=docente" class="active">Dashboard</a></li>
                <li><a href="index.php?c=estudiante">Ver Estudiantes</a></li>
                <li class="nav-user">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?> (Docente)</span>
                    <a href="index.php?c=auth&a=logout" class="btn btn-small btn-danger">Salir</a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-main">
        <div class="container">
            
            <div class="dashboard-welcome">
                <h2>Bienvenido, Docente</h2>
                <p>Panel de gestión de tutorías y estudiantes</p>
            </div>

            <!-- Estadísticas del Docente -->
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
                        <p>Tutorías Realizadas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👨‍🎓</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Estudiantes Asignados</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Fichas Registradas</p>
                    </div>
                </div>

            </div>

            <!-- Acciones Rápidas -->
            <div class="dashboard-section">
                <h3>Acciones Rápidas</h3>
                <div class="action-grid">
                    
                    <a href="index.php?c=estudiante" class="action-card">
                        <div class="action-icon">👨‍🎓</div>
                        <h4>Ver Estudiantes</h4>
                        <p>Consultar lista de estudiantes</p>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">📅</div>
                        <h4>Mis Tutorías</h4>
                        <p>Ver y gestionar tutorías programadas</p>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">📝</div>
                        <h4>Registrar Sesión</h4>
                        <p>Llenar ficha de tutoría</p>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">📊</div>
                        <h4>Mis Reportes</h4>
                        <p>Ver historial y estadísticas</p>
                    </a>

                </div>
            </div>

            <!-- Próximas Tutorías -->
            <div class="dashboard-section">
                <h3>Próximas Tutorías</h3>
                <div class="info-box">
                    <p class="text-muted">No hay tutorías programadas próximamente</p>
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

