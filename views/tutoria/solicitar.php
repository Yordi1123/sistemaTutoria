<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📝 Solicitar Tutoría</h2>
    <p>Completa el formulario para solicitar una sesión de tutoría</p>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?c=tutoria&a=store" method="POST" class="form">
        
        <div class="form-group">
            <label for="docente_id">Tutor / Docente *</label>
            <select id="docente_id" name="docente_id" required>
                <option value="">Selecciona un tutor</option>
                <?php foreach ($tutores as $tutor): ?>
                    <option value="<?php echo $tutor['id']; ?>" <?php echo (isset($_SESSION['old']['docente_id']) && $_SESSION['old']['docente_id'] == $tutor['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tutor['apellidos'] . ', ' . $tutor['nombres']); ?> 
                        - <?php echo htmlspecialchars($tutor['especialidad']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha *</label>
            <input type="date" 
                   id="fecha" 
                   name="fecha" 
                   min="<?php echo date('Y-m-d'); ?>"
                   value="<?php echo isset($_SESSION['old']['fecha']) ? htmlspecialchars($_SESSION['old']['fecha']) : ''; ?>"
                   required>
            <small>Selecciona una fecha a partir de hoy</small>
        </div>

        <div class="form-group">
            <label for="hora">Hora *</label>
            <select id="hora" name="hora" required>
                <option value="">Selecciona una hora</option>
                <option value="08:00:00">08:00 AM</option>
                <option value="09:00:00">09:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="13:00:00">01:00 PM</option>
                <option value="14:00:00">02:00 PM</option>
                <option value="15:00:00">03:00 PM</option>
                <option value="16:00:00">04:00 PM</option>
                <option value="17:00:00">05:00 PM</option>
                <option value="18:00:00">06:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo / Tema a tratar *</label>
            <textarea id="motivo" 
                      name="motivo" 
                      rows="4" 
                      placeholder="Describe el tema o motivo de la tutoría"
                      required><?php echo isset($_SESSION['old']['motivo']) ? htmlspecialchars($_SESSION['old']['motivo']) : ''; ?></textarea>
            <small>Sé específico para que el tutor pueda prepararse mejor</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">📝 Enviar Solicitud</button>
            <a href="index.php?c=dashboard&a=estudiante" class="btn">Cancelar</a>
        </div>
    </form>

    <?php unset($_SESSION['old']); ?>
</div>

<?php require_once 'views/layout/footer.php'; ?>

