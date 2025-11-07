<div class="usuarios-page">
    <h1>Lista de Usuarios</h1>
    
    <a href="<?= url('usuarios/create') ?>" class="btn">Nuevo Usuario</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="4">No hay usuarios registrados</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= e($usuario['id']) ?></td>
                        <td><?= e($usuario['nombre']) ?></td>
                        <td><?= e($usuario['email']) ?></td>
                        <td>
                            <a href="<?= url('usuarios/' . $usuario['id']) ?>">Ver</a> |
                            <a href="<?= url('usuarios/' . $usuario['id'] . '/edit') ?>">Editar</a> |
                            <a href="<?= url('usuarios/' . $usuario['id'] . '/delete') ?>" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

