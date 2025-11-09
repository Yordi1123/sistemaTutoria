<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tutoría - UNS</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="landing-page">
    
    <!-- Navbar -->
    <nav class="landing-nav">
        <div class="container">
            <div class="nav-content">
                <div class="logo">
                    <h1>🎓 Sistema de Tutoría</h1>
                </div>
                <div class="nav-links">
                    <a href="index.php?c=auth&a=login" class="btn btn-outline">Iniciar Sesión</a>
                    <a href="index.php?c=auth&a=register" class="btn btn-primary">Registrarse</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenido al Sistema de Tutoría UNS</h1>
                <p class="hero-subtitle">Gestiona tutorías, consejerías y acompañamiento académico de forma eficiente</p>
                <div class="hero-buttons">
                    <a href="index.php?c=auth&a=register" class="btn btn-large btn-primary">Comenzar Ahora</a>
                    <a href="#features" class="btn btn-large btn-outline">Conocer Más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title">¿Qué Ofrece el Sistema?</h2>
            <div class="features-grid">
                
                <div class="feature-card">
                    <div class="feature-icon">👨‍🎓</div>
                    <h3>Para Estudiantes</h3>
                    <p>Solicita tutorías, agenda consejerías y consulta tu historial académico</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👨‍🏫</div>
                    <h3>Para Docentes</h3>
                    <p>Gestiona tutorías, lleva el seguimiento de estudiantes y registra avances</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👔</div>
                    <h3>Para Administradores</h3>
                    <p>Supervisa el sistema, genera reportes y administra usuarios</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3>Gestión de Citas</h3>
                    <p>Programa y organiza tutorías y consejerías fácilmente</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Reportes</h3>
                    <p>Visualiza estadísticas y genera informes detallados</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Seguro</h3>
                    <p>Tus datos están protegidos con tecnología segura</p>
                </div>

            </div>
        </div>
    </section>

    <!-- User Types Section -->
    <section class="user-types">
        <div class="container">
            <h2 class="section-title">Tipos de Usuario</h2>
            <div class="types-grid">
                
                <div class="type-card">
                    <div class="type-icon">🎓</div>
                    <h3>Estudiante</h3>
                    <ul>
                        <li>Solicitar tutorías</li>
                        <li>Agendar consejerías</li>
                        <li>Ver historial</li>
                        <li>Consultar horarios</li>
                    </ul>
                    <a href="index.php?c=auth&a=register" class="btn">Registrarse</a>
                </div>

                <div class="type-card">
                    <div class="type-icon">👨‍🏫</div>
                    <h3>Docente/Tutor</h3>
                    <ul>
                        <li>Gestionar tutorías</li>
                        <li>Atender estudiantes</li>
                        <li>Registrar sesiones</li>
                        <li>Hacer seguimiento</li>
                    </ul>
                    <a href="index.php?c=auth&a=login" class="btn">Ingresar</a>
                </div>

                <div class="type-card">
                    <div class="type-icon">⚙️</div>
                    <h3>Administrador</h3>
                    <ul>
                        <li>Administrar usuarios</li>
                        <li>Generar reportes</li>
                        <li>Supervisar sistema</li>
                        <li>Configurar plataforma</li>
                    </ul>
                    <a href="index.php?c=auth&a=login" class="btn">Ingresar</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> - Sistema de Tutoría UNS</p>
            <p>Universidad Nacional del Santa</p>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>

