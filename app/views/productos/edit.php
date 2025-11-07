<div class="productos-form">
    <h1>Editar Producto</h1>
    
    <form method="POST" action="<?= url('productos/' . $producto['id']) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= e($producto['nombre']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?= e($producto['precio']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?= e($producto['descripcion']) ?></textarea>
        </div>
        
        <button type="submit" class="btn">Actualizar</button>
        <a href="<?= url('productos') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

