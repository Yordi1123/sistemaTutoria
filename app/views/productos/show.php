<div class="productos-show">
    <h1>Detalle del Producto</h1>
    
    <div class="info-box">
        <p><strong>ID:</strong> <?= e($producto['id']) ?></p>
        <p><strong>Nombre:</strong> <?= e($producto['nombre']) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></p>
        <p><strong>Descripción:</strong> <?= e($producto['descripcion']) ?></p>
    </div>
    
    <a href="<?= url('productos') ?>" class="btn">Volver</a>
    <a href="<?= url('productos/' . $producto['id'] . '/edit') ?>" class="btn">Editar</a>
</div>

