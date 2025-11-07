<div class="productos-form">
    <h1>Crear Producto</h1>
    
    <form method="POST" action="<?= url('productos') ?>">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn">Guardar</button>
        <a href="<?= url('productos') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

