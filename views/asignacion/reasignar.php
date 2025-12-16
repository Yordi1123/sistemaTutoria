<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>🔄 Reasignar Estudiante</h2>
    <p>Transferir estudiante a otro tutor</p>

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

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Información actual -->
    <div class="info-card" style="margin-bottom: 2rem;">
        <h4>📌 Asignación Actual</h4>
        <div class="info-grid">
            <div class="info-item">
                <span class="label">Estudiante:</span>
                <span class="value"><?php echo htmlspecialchars($asignacion['estudiante_apellidos'] . ', ' . $asignacion['estudiante_nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Código:</span>
                <span class="value"><?php echo htmlspecialchars($asignacion['estudiante_codigo']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Tutor Actual:</span>
                <span class="value"><?php echo htmlspecialchars($asignacion['docente_apellidos'] . ', ' . $asignacion['docente_nombres']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Desde:</span>
                <span class="value"><?php echo date('d/m/Y', strtotime($asignacion['fecha_asignacion'])); ?></span>
            </div>
        </div>
    </div>

    <form action="index.php?c=asignacion&a=guardarReasignacion" method="POST" class="form-card">
        <input type="hidden" name="id" value="<?php echo $asignacion['id']; ?>">
        
        <div class="form-group">
            <label for="docente_id">Nuevo Docente/Tutor *</label>
            <select name="docente_id" id="docente_id" required>
                <option value="">-- Seleccionar Nuevo Tutor --</option>
                <?php foreach ($tutores as $tutor): ?>
                    <?php if ($tutor['id'] != $asignacion['docente_id']): ?>
                        <option value="<?php echo $tutor['id']; ?>">
                            <?php echo htmlspecialchars($tutor['codigo'] . ' - ' . $tutor['apellidos'] . ', ' . $tutor['nombres']); ?>
                            (<?php echo $tutor['especialidad']; ?>) 
                            - <?php echo $tutor['total_asignados']; ?> asignados
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo de la Reasignación *</label>
            <textarea name="motivo" id="motivo" rows="4" required 
                      placeholder="Ingrese el motivo por el cual se reasigna al estudiante..."><?php echo isset($_SESSION['old']['motivo']) ? htmlspecialchars($_SESSION['old']['motivo']) : ''; ?></textarea>
            <small>Este motivo quedará registrado en el historial del estudiante</small>
        </div>

        <div class="alert alert-warning" style="margin-bottom: 1.5rem;">
            <strong>⚠️ Importante:</strong> La reasignación desactivará la asignación actual y creará una nueva. 
            El historial quedará registrado y podrá consultarse posteriormente.
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">🔄 Confirmar Reasignación</button>
            <a href="index.php?c=asignacion" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

<style>
.info-card {
    background: #e8f4fd;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #3498db;
}
.info-card h4 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.info-item {
    display: flex;
    flex-direction: column;
}
.info-item .label {
    font-size: 0.85rem;
    color: #7f8c8d;
}
.info-item .value {
    font-weight: 600;
    color: #2c3e50;
}
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
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    font-family: inherit;
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
.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    padding: 1rem;
    border-radius: 8px;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
