<?php include VIEWS_PATH . 'layout/header.php'; ?>

<h1>Solicitar Tutoría</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= e($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= url('estudiante/solicitar') ?>">
    <?= csrf_field() ?>
    
    <div class="form-group">
        <label for="docente_id">Docente:</label>
        <select id="docente_id" name="docente_id" required>
            <option value="">Seleccione un docente</option>
            <?php foreach ($docentes as $docente): ?>
                <option value="<?= $docente['id'] ?>">
                    <?= e($docente['nombres'] . ' ' . $docente['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
    </div>

    <div class="form-group">
        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>
    </div>

    <div class="form-group">
        <label for="motivo">Motivo:</label>
        <textarea id="motivo" name="motivo" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Solicitar Tutoría</button>
    <a href="<?= url('estudiante/dashboard') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?php include VIEWS_PATH . 'layout/footer.php'; ?>

