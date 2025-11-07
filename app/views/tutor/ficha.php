<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Ficha de Tutoría</h1>

<h2>Información de la Tutoría</h2>
<p><strong>Fecha:</strong> <?= e($tutoria['fecha']) ?></p>
<p><strong>Hora:</strong> <?= e($tutoria['hora']) ?></p>
<p><strong>Estudiante:</strong> <?= e($tutoria['estudiante_nombres'] . ' ' . $tutoria['estudiante_apellidos']) ?></p>
<p><strong>Motivo:</strong> <?= e($tutoria['motivo']) ?></p>

<h2>Registrar Ficha</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= e($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= url('tutor/ficha/' . $tutoria['id']) ?>">
    <?= csrf_field() ?>
    
    <div class="form-group">
        <label for="problematica">Problemática:</label>
        <textarea id="problematica" name="problematica" rows="4"><?= e($ficha['problematica'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="acciones">Acciones Realizadas:</label>
        <textarea id="acciones" name="acciones" rows="4"><?= e($ficha['acciones'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="conclusiones">Conclusiones:</label>
        <textarea id="conclusiones" name="conclusiones" rows="4"><?= e($ficha['conclusiones'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Ficha</button>
    <a href="<?= url('tutor/tutorias') ?>" class="btn btn-secondary">Volver</a>
</form>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

