<div class="usuarios-form">
    <h1>Editar Usuario</h1>
    
    <form method="POST" action="<?= url('usuarios/' . $usuario['id']) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= e($usuario['nombre']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= e($usuario['email']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" id="password" name="password">
        </div>
        
        <button type="submit" class="btn">Actualizar</button>
        <a href="<?= url('usuarios') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

