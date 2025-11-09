<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Tutoría</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="auth-page">
    
    <div class="auth-container">
        <div class="auth-box">
            
            <div class="auth-header">
                <h1>🎓 Sistema de Tutoría</h1>
                <p>Crear Cuenta</p>
            </div>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&a=store" method="POST" class="auth-form">
                
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Ej: juan123 o 0201910001"
                           value="<?php echo isset($_SESSION['old']['username']) ? htmlspecialchars($_SESSION['old']['username']) : ''; ?>"
                           required 
                           autofocus>
                    <small>Para estudiantes: usa tu código. Para docentes: usa tu código docente</small>
                </div>

                <div class="form-group">
                    <label for="rol">Tipo de Usuario</label>
                    <select id="rol" name="rol" required>
                        <option value="">Selecciona un tipo</option>
                        <option value="estudiante" <?php echo (isset($_SESSION['old']['rol']) && $_SESSION['old']['rol'] == 'estudiante') ? 'selected' : ''; ?>>
                            Estudiante
                        </option>
                        <option value="docente" <?php echo (isset($_SESSION['old']['rol']) && $_SESSION['old']['rol'] == 'docente') ? 'selected' : ''; ?>>
                            Docente/Tutor
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Mínimo 6 caracteres"
                           required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" 
                           id="password_confirm" 
                           name="password_confirm" 
                           placeholder="Repite tu contraseña"
                           required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Registrarse</button>

            </form>

            <div class="auth-footer">
                <p>¿Ya tienes cuenta? <a href="index.php?c=auth&a=login">Inicia sesión aquí</a></p>
                <p><a href="index.php">← Volver al inicio</a></p>
            </div>

        </div>
    </div>

    <?php unset($_SESSION['old']); ?>

    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>

