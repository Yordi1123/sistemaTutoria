<div class="productos-page">
    <h1>Lista de Productos</h1>
    
    <a href="<?= url('productos/create') ?>" class="btn">Nuevo Producto</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="5">No hay productos registrados</td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= e($producto['id']) ?></td>
                        <td><?= e($producto['nombre']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= e($producto['descripcion']) ?></td>
                        <td>
                            <a href="<?= url('productos/' . $producto['id']) ?>">Ver</a> |
                            <a href="<?= url('productos/' . $producto['id'] . '/edit') ?>">Editar</a> |
                            <a href="<?= url('productos/' . $producto['id'] . '/delete') ?>" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

