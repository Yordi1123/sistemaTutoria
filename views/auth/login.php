<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Tutoría UNS</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>assets/img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0a0a0a;
            --primary-black: #111111;
            --accent-red: #c41e3a;
            --accent-red-dark: #a01830;
            --accent-red-light: #e63950;
            --text-white: #ffffff;
            --text-light: #e0e0e0;
            --text-muted: #888888;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.08);
            --input-bg: rgba(255, 255, 255, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-black) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(circle at 80% 20%, rgba(196, 30, 58, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 2;
        }

        .auth-box {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 3rem;
            backdrop-filter: blur(10px);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            height: 70px;
            margin-bottom: 1rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: var(--text-light);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: var(--input-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            color: var(--text-white);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-group input::placeholder {
            color: var(--text-muted);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-red);
            box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--accent-red), var(--accent-red-dark));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(196, 30, 58, 0.4);
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--card-border);
        }

        .auth-footer p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .auth-footer a {
            color: var(--accent-red-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .auth-footer a:hover {
            color: var(--text-white);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 1rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--accent-red-light);
        }

        @media (max-width: 480px) {
            .auth-box { padding: 2rem; }
            .auth-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-box">
            
            <div class="auth-header">
                <img src="<?php echo BASE_URL; ?>assets/img/logo-uns.png" alt="Logo UNS" class="auth-logo">
                <h1>Iniciar Sesión</h1>
                <p>Sistema de Tutoría Universitaria</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&a=authenticate" method="POST">
                
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Ingresa tu código o usuario"
                           required 
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Ingresa tu contraseña"
                           required>
                </div>

                <button type="submit" class="btn-submit">🔐 Iniciar Sesión</button>

            </form>

            <div class="auth-footer">
                <p>¿No tienes cuenta? <a href="index.php?c=auth&a=register">Regístrate aquí</a></p>
                <a href="index.php" class="back-link">← Volver al inicio</a>
            </div>

        </div>
    </div>

</body>
</html>
