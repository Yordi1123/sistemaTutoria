<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>➕ Nueva Asignación Tutor-Estudiante</h2>
    <p>Asignar un estudiante a un tutor de forma permanente</p>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.5rem;">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (empty($estudiantes)): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <strong>✅ ¡Excelente!</strong> Todos los estudiantes ya tienen un tutor asignado.
        </div>
        <a href="index.php?c=asignacion" class="btn">← Volver a Asignaciones</a>
    <?php else: ?>
        <form action="index.php?c=asignacion&a=store" method="POST" class="form-card">
            
            <div class="form-group">
                <label for="estudiante_id">Estudiante *</label>
                <select name="estudiante_id" id="estudiante_id" required>
                    <option value="">-- Seleccionar Estudiante --</option>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?php echo $estudiante['id']; ?>">
                            <?php echo htmlspecialchars($estudiante['codigo'] . ' - ' . $estudiante['apellidos'] . ', ' . $estudiante['nombres'] . ' (Ciclo ' . $estudiante['ciclo'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small>Solo se muestran estudiantes sin asignación actual</small>
            </div>

            <div class="form-group">
                <label for="docente_id">Docente/Tutor *</label>
                <select name="docente_id" id="docente_id" required>
                    <option value="">-- Seleccionar Docente --</option>
                    <?php foreach ($tutores as $tutor): ?>
                        <option value="<?php echo $tutor['id']; ?>">
                            <?php echo htmlspecialchars($tutor['codigo'] . ' - ' . $tutor['apellidos'] . ', ' . $tutor['nombres']); ?>
                            (<?php echo $tutor['especialidad']; ?>) 
                            - <?php echo $tutor['total_asignados']; ?> asignados
                        </option>
                    <?php endforeach; ?>
                </select>
                <small>El número indica cantidad de estudiantes asignados actualmente</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Guardar Asignación</button>
                <a href="index.php?c=asignacion" class="btn">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
.form-card {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    max-width: 600px;
}
.form-group {
    margin-bottom: 1.5rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
}
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}
.form-group small {
    display: block;
    margin-top: 0.25rem;
    color: #7f8c8d;
    font-size: 0.85rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
