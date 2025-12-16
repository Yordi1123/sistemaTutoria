<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - Sistema de Tutoría</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="dashboard-admin">
    
    <!-- Navbar -->
    <header class="dashboard-header">
        <nav>
            <div class="nav-brand">
                <h1>🎓 Sistema de Tutoría</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php?c=dashboard&a=admin" class="active">Dashboard</a></li>
                <li><a href="index.php?c=estudiante">Estudiantes</a></li>
                <li><a href="index.php?c=tutor">Tutores</a></li>
                <li class="nav-user">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</span>
                    <a href="index.php?c=auth&a=logout" class="btn btn-small btn-danger">Salir</a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-main">
        <div class="container">
            
            <?php
            $breadcrumbs = [
                ['nombre' => 'Dashboard Administrador']
            ];
            include 'views/components/breadcrumb.php';
            ?>
            
            <div class="dashboard-welcome">
                <h2>Bienvenido, Administrador</h2>
                <p>Panel de control y administración del sistema</p>
            </div>

            <!-- Estadísticas -->
            <div class="stats-grid">
                
                <div class="stat-card">
                    <div class="stat-icon">👨‍🎓</div>
                    <div class="stat-content">
                        <h3><?php echo $totalEstudiantes; ?></h3>
                        <p>Estudiantes Registrados</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👨‍🏫</div>
                    <div class="stat-content">
                        <h3><?php echo $totalTutores; ?></h3>
                        <p>Tutores/Docentes</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <h3><?php echo $totalUsuarios; ?></h3>
                        <p>Usuarios Totales</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h3>0</h3>
                        <p>Tutorías Activas</p>
                    </div>
                </div>

            </div>

            <!-- Acciones Rápidas -->
            <div class="dashboard-section">
                <h3>Acciones Rápidas</h3>
                <div class="action-grid">
                    
                    <a href="index.php?c=estudiante" class="action-card">
                        <div class="action-icon">👨‍🎓</div>
                        <h4>Gestionar Estudiantes</h4>
                        <p>Ver, agregar o editar estudiantes</p>
                    </a>

                    <a href="index.php?c=tutor" class="action-card">
                        <div class="action-icon">👨‍🏫</div>
                        <h4>Gestionar Tutores</h4>
                        <p>Administrar tutores y docentes</p>
                    </a>

                    <a href="index.php?c=estudiante&a=create" class="action-card">
                        <div class="action-icon">➕</div>
                        <h4>Nuevo Estudiante</h4>
                        <p>Registrar un nuevo estudiante</p>
                    </a>

                    <a href="index.php?c=tutor&a=create" class="action-card">
                        <div class="action-icon">➕</div>
                        <h4>Nuevo Tutor</h4>
                        <p>Registrar un nuevo tutor</p>
                    </a>

                    <a href="index.php?c=asignacion" class="action-card">
                        <div class="action-icon">🔗</div>
                        <h4>Asignaciones</h4>
                        <p>Asignar estudiantes a tutores</p>
                    </a>

                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="dashboard-section">
                <h3>Información del Sistema</h3>
                <div class="info-box">
                    <p><strong>Rol:</strong> Administrador/Coordinador</p>
                    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <p><strong>Última actualización:</strong> <?php echo date('d/m/Y H:i'); ?></p>
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

