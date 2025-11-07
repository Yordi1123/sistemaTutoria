<div class="usuarios-show">
    <h1>Detalle del Usuario</h1>
    
    <div class="info-box">
        <p><strong>ID:</strong> <?= e($usuario['id']) ?></p>
        <p><strong>Nombre:</strong> <?= e($usuario['nombre']) ?></p>
        <p><strong>Email:</strong> <?= e($usuario['email']) ?></p>
    </div>
    
    <a href="<?= url('usuarios') ?>" class="btn">Volver</a>
    <a href="<?= url('usuarios/' . $usuario['id'] . '/edit') ?>" class="btn">Editar</a>
</div>

