<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Tutoría</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="auth-page">
    
    <div class="auth-container">
        <div class="auth-box">
            
            <div class="auth-header">
                <h1>🎓 Sistema de Tutoría</h1>
                <p>Iniciar Sesión</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&a=authenticate" method="POST" class="auth-form">
                
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Ingresa tu usuario"
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

                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>

            </form>

            <div class="auth-footer">
                <p>¿No tienes cuenta? <a href="index.php?c=auth&a=register">Regístrate aquí</a></p>
                <p><a href="index.php">← Volver al inicio</a></p>
            </div>

        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>

