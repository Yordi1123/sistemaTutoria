<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Tutoría Universitaria - Universidad Nacional del Santa. Gestión integral de tutorías y consejerías para el acompañamiento académico estudiantil.">
    <meta name="keywords" content="tutoría, universidad, UNS, educación, acompañamiento académico">
    <title>Sistema de Tutoría | Universidad Nacional del Santa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Paleta inspirada en la imagen - Gradiente oscuro/magenta */
            --primary-dark: #0a0a0a;
            --primary-gradient-start: #1a1a2e;
            --primary-gradient-mid: #2d1b3d;
            --primary-gradient-end: #4a1942;
            --accent-magenta: #8b2e6e;
            --accent-purple: #6b3fa0;
            --accent-light: #c94b9e;
            --text-white: #ffffff;
            --text-light: #e0e0e0;
            --text-muted: #a0a0a0;
            --gold-accent: #d4af37;
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-gradient-start) 25%, var(--primary-gradient-mid) 50%, var(--primary-gradient-end) 100%);
            color: var(--text-white);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: rgba(10, 10, 10, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--card-border);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-text h1 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-white);
        }

        .logo-text span {
            font-size: 0.75rem;
            color: var(--gold-accent);
            font-weight: 500;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent-light);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 46, 110, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 2rem 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: radial-gradient(circle at 70% 30%, rgba(139, 46, 110, 0.3) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.85rem;
            color: var(--gold-accent);
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--accent-light), var(--gold-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(139, 46, 110, 0.5);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-white);
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid var(--card-border);
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--card-bg);
            border-color: var(--accent-light);
        }

        /* Stats Cards */
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent-light);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
        }

        .feature-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s, border-color 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-magenta);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .feature-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* Services Section */
        .services {
            padding: 6rem 2rem;
            background: rgba(0, 0, 0, 0.3);
        }

        .section-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            color: var(--gold-accent);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .service-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-magenta);
            box-shadow: 0 20px 60px rgba(139, 46, 110, 0.2);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
        }

        .service-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .service-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Info Section */
        .info-section {
            padding: 6rem 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .info-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .info-content p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .info-list {
            list-style: none;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .info-list li::before {
            content: '✓';
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--accent-magenta), var(--accent-purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .info-visual {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 3rem;
        }

        .info-visual h3 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--gold-accent);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .contact-text span {
            display: block;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .contact-text strong {
            font-size: 1rem;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.5);
            border-top: 1px solid var(--card-border);
            padding: 4rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.95rem;
            max-width: 300px;
        }

        .footer-column h4 {
            font-size: 1rem;
            margin-bottom: 1.5rem;
            color: var(--gold-accent);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 0.75rem;
        }

        .footer-column a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .footer-column a:hover {
            color: var(--accent-light);
        }

        .footer-bottom {
            border-top: 1px solid var(--card-border);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container { grid-template-columns: 1fr; text-align: center; }
            .hero-description { margin: 0 auto 2rem; }
            .hero-buttons { justify-content: center; }
            .hero-stats { justify-content: center; }
            .feature-cards { max-width: 500px; margin: 3rem auto 0; }
            .services-grid { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .header-container { flex-direction: column; gap: 1rem; }
            .nav-links { display: none; }
            .hero-title { font-size: 2.5rem; }
            .hero-buttons { flex-direction: column; }
            .feature-cards { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <div class="logo-icon">🎓</div>
                <div class="logo-text">
                    <h1>Sistema de Tutoría</h1>
                    <span>Universidad Nacional del Santa</span>
                </div>
            </div>
            <nav class="nav-links">
                <a href="#inicio">Inicio</a>
                <a href="#servicios">Servicios</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#contacto">Contacto</a>
                <a href="index.php?c=auth&a=login" class="btn-login">Iniciar Sesión</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">🏛️ Universidad Nacional del Santa - Chimbote, Perú</div>
                <h1 class="hero-title">
                    Programa de <span>Tutoría Universitaria</span>
                </h1>
                <p class="hero-description">
                    Acompañamiento académico integral para el desarrollo personal y profesional de nuestros estudiantes. 
                    Fortalecemos tu trayectoria universitaria con orientación especializada.
                </p>
                <div class="hero-buttons">
                    <a href="index.php?c=auth&a=login" class="btn-primary">🔐 Acceder al Sistema</a>
                    <a href="#servicios" class="btn-secondary">Conocer más →</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Estudiantes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Tutores</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Satisfacción</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="feature-cards">
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3>Tutoría Académica</h3>
                        <p>Orientación en materias y desarrollo de habilidades de estudio</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🧠</div>
                        <h3>Consejería</h3>
                        <p>Apoyo psicológico y bienestar emocional estudiantil</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📅</div>
                        <h3>Agenda Digital</h3>
                        <p>Programa y gestiona tus sesiones fácilmente</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Seguimiento</h3>
                        <p>Monitoreo continuo de tu progreso académico</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="servicios">
        <div class="section-container">
            <div class="section-header">
                <p class="section-subtitle">Nuestros Servicios</p>
                <h2 class="section-title">¿Qué ofrecemos?</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">👨‍🏫</div>
                    <h3>Tutoría Personalizada</h3>
                    <p>Asignación de un tutor académico que te acompañará durante toda tu carrera universitaria, brindándote orientación académica y profesional.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💬</div>
                    <h3>Consejería Psicológica</h3>
                    <p>Servicio de apoyo emocional con profesionales capacitados para ayudarte a superar cualquier dificultad personal o académica.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🎯</div>
                    <h3>Orientación Vocacional</h3>
                    <p>Ayuda para definir tu proyecto de vida profesional, identificando tus fortalezas y oportunidades de desarrollo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section" id="nosotros">
        <div class="section-container">
            <div class="info-grid">
                <div class="info-content">
                    <h2>Compromiso con tu Formación Integral</h2>
                    <p>
                        El Programa de Tutoría de la Universidad Nacional del Santa está diseñado para garantizar 
                        tu éxito académico y desarrollo personal durante tu formación universitaria.
                    </p>
                    <ul class="info-list">
                        <li>Acompañamiento académico personalizado</li>
                        <li>Sesiones individuales y grupales</li>
                        <li>Seguimiento del rendimiento académico</li>
                        <li>Apoyo en trámites y procesos universitarios</li>
                        <li>Talleres de desarrollo de habilidades blandas</li>
                    </ul>
                </div>
                <div class="info-visual" id="contacto">
                    <h3>📍 Información de Contacto</h3>
                    <div class="contact-item">
                        <div class="contact-icon">🏛️</div>
                        <div class="contact-text">
                            <span>Dirección</span>
                            <strong>Av. Universitaria s/n, Urb. Bellamar, Nuevo Chimbote</strong>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-text">
                            <span>Teléfono</span>
                            <strong>(043) 310-445</strong>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <div class="contact-text">
                            <span>Email</span>
                            <strong>tutoria@uns.edu.pe</strong>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🌐</div>
                        <div class="contact-text">
                            <span>Sitio Web</span>
                            <strong>www.uns.edu.pe</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>🎓 Sistema de Tutoría UNS</h3>
                    <p>
                        Plataforma digital para la gestión integral del programa de tutoría universitaria, 
                        facilitando la comunicación entre estudiantes, tutores y consejeros.
                    </p>
                </div>
                <div class="footer-column">
                    <h4>Acceso Rápido</h4>
                    <ul>
                        <li><a href="index.php?c=auth&a=login">Iniciar Sesión</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#nosotros">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Usuarios</h4>
                    <ul>
                        <li><a href="#">Estudiantes</a></li>
                        <li><a href="#">Docentes Tutores</a></li>
                        <li><a href="#">Consejeros</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Universidad</h4>
                    <ul>
                        <li><a href="https://www.uns.edu.pe" target="_blank">Portal UNS</a></li>
                        <li><a href="#">Bienestar Universitario</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© <?php echo date('Y'); ?> Universidad Nacional del Santa. Todos los derechos reservados.</p>
                <p>Sistema de Tutoría Universitaria v1.0</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

</body>
</html>
