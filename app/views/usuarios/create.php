<div class="usuarios-form">
    <h1>Crear Usuario</h1>
    
    <form method="POST" action="<?= url('usuarios') ?>">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Guardar</button>
        <a href="<?= url('usuarios') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

