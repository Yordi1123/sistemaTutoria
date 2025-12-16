<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>🧠 Solicitar Consejería</h2>
    <p>Programa una cita con un consejero para atención psicológica o personal</p>

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

    <form action="index.php?c=consejeria&a=guardar" method="POST" class="form-card">
        
        <div class="form-group">
            <label for="consejero_id">Consejero *</label>
            <select name="consejero_id" id="consejero_id" required>
                <option value="">-- Seleccionar Consejero --</option>
                <?php foreach ($consejeros as $consejero): ?>
                    <option value="<?php echo $consejero['id']; ?>" 
                            <?php echo (isset($_SESSION['old']['consejero_id']) && $_SESSION['old']['consejero_id'] == $consejero['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($consejero['nombres'] . ' ' . $consejero['apellidos']); ?>
                        (<?php echo $consejero['especialidad']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="fecha">Fecha *</label>
                <input type="date" name="fecha" id="fecha" required 
                       min="<?php echo date('Y-m-d'); ?>"
                       value="<?php echo $_SESSION['old']['fecha'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label for="hora">Hora *</label>
                <input type="time" name="hora" id="hora" required
                       value="<?php echo $_SESSION['old']['hora'] ?? ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo de la Consulta *</label>
            <textarea name="motivo" id="motivo" rows="4" required 
                      placeholder="Describe brevemente el motivo de tu consulta..."><?php echo $_SESSION['old']['motivo'] ?? ''; ?></textarea>
            <small>Esta información es confidencial y será tratada con discreción</small>
        </div>

        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
            <strong>🔒 Confidencialidad:</strong> Tu solicitud será tratada de manera confidencial. 
            El consejero revisará tu solicitud y confirmará la cita.
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">📩 Enviar Solicitud</button>
            <a href="index.php?c=dashboard&a=estudiante" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

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
.form-group input,
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
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
