<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2><?php echo $action == 'crear' ? '➕ Nuevo Consejero' : '✏️ Editar Consejero'; ?></h2>
    <p><?php echo $action == 'crear' ? 'Registra un nuevo consejero en el sistema' : 'Modifica los datos del consejero'; ?></p>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.5rem;">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form action="index.php?c=consejero&a=<?php echo $action == 'crear' ? 'store' : 'update'; ?>" 
          method="POST" class="form-card">
        
        <?php if ($action == 'editar'): ?>
            <input type="hidden" name="id" value="<?php echo $consejero['id']; ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="codigo">Código *</label>
                <input type="text" name="codigo" id="codigo" required 
                       placeholder="CONS002"
                       value="<?php echo $_SESSION['old']['codigo'] ?? ($consejero['codigo'] ?? ''); ?>"
                       <?php echo $action == 'editar' ? 'readonly' : ''; ?>>
                <small>Este será el usuario para iniciar sesión</small>
            </div>

            <div class="form-group">
                <label for="especialidad">Especialidad</label>
                <select name="especialidad" id="especialidad">
                    <option value="">-- Seleccionar --</option>
                    <option value="Psicologia" <?php echo (($_SESSION['old']['especialidad'] ?? ($consejero['especialidad'] ?? '')) == 'Psicologia') ? 'selected' : ''; ?>>Psicología</option>
                    <option value="Orientacion Vocacional" <?php echo (($_SESSION['old']['especialidad'] ?? ($consejero['especialidad'] ?? '')) == 'Orientacion Vocacional') ? 'selected' : ''; ?>>Orientación Vocacional</option>
                    <option value="Trabajo Social" <?php echo (($_SESSION['old']['especialidad'] ?? ($consejero['especialidad'] ?? '')) == 'Trabajo Social') ? 'selected' : ''; ?>>Trabajo Social</option>
                    <option value="Bienestar Estudiantil" <?php echo (($_SESSION['old']['especialidad'] ?? ($consejero['especialidad'] ?? '')) == 'Bienestar Estudiantil') ? 'selected' : ''; ?>>Bienestar Estudiantil</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nombres">Nombres *</label>
                <input type="text" name="nombres" id="nombres" required 
                       placeholder="Nombres completos"
                       value="<?php echo $_SESSION['old']['nombres'] ?? ($consejero['nombres'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos *</label>
                <input type="text" name="apellidos" id="apellidos" required 
                       placeholder="Apellidos completos"
                       value="<?php echo $_SESSION['old']['apellidos'] ?? ($consejero['apellidos'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   placeholder="correo@universidad.edu.pe"
                   value="<?php echo $_SESSION['old']['email'] ?? ($consejero['email'] ?? ''); ?>">
        </div>

        <?php if ($action == 'crear'): ?>
        <div class="form-group">
            <label for="password">Contraseña *</label>
            <input type="password" name="password" id="password" required 
                   placeholder="Contraseña para acceso al sistema">
            <small>Mínimo 6 caracteres</small>
        </div>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?php echo $action == 'crear' ? '💾 Registrar Consejero' : '💾 Actualizar Consejero'; ?>
            </button>
            <a href="index.php?c=consejero" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

<style>
.form-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 700px;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
}
.form-group input,
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}
.form-group input[readonly] {
    background: #f8f9fa;
    color: #666;
}
.form-group small {
    display: block;
    margin-top: 0.25rem;
    color: #7f8c8d;
    font-size: 0.85rem;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
