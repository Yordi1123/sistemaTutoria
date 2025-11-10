<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>📅 Reprogramar Tutoría</h2>
        <a href="index.php?c=tutoria&a=mistutorias" class="btn">← Volver</a>
    </div>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Información Actual -->
    <div class="card">
        <div class="card-header">
            <h3>📋 Información Actual</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Tutor:</strong> <?= htmlspecialchars($tutoria['tutor_nombres'] . ' ' . $tutoria['tutor_apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Fecha Actual:</strong> <?= date('d/m/Y', strtotime($tutoria['fecha'])) ?>
                </div>
                <div class="info-item">
                    <strong>Hora Actual:</strong> <?= date('H:i', strtotime($tutoria['hora'])) ?>
                </div>
                <div class="info-item">
                    <strong>Estado:</strong> 
                    <span class="badge badge-<?= $tutoria['estado'] == 'confirmada' ? 'info' : 'warning' ?>">
                        <?= ucfirst($tutoria['estado']) ?>
                    </span>
                </div>
            </div>
            <div class="info-item" style="margin-top: 10px;">
                <strong>Motivo:</strong>
                <p><?= nl2br(htmlspecialchars($tutoria['motivo'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Instrucciones -->
    <div class="alert alert-warning">
        <strong>⚠️ Importante:</strong> Al reprogramar tu tutoría, el estado volverá a "pendiente" y el tutor deberá confirmarla nuevamente.
    </div>

    <form action="index.php?c=tutoria&a=actualizarProgramacion" method="POST" class="form-card">
        <input type="hidden" name="id" value="<?= $tutoria['id'] ?>">

        <!-- Tutor actual (solo informativo, no se puede cambiar) -->
        <div class="form-group">
            <label>Tutor</label>
            <input type="text" 
                   value="<?= htmlspecialchars($tutoria['tutor_nombres'] . ' ' . $tutoria['tutor_apellidos'] . ' - ' . $tutoria['tutor_especialidad']) ?>" 
                   disabled 
                   style="background: #f0f0f0;">
            <small>Para cambiar de tutor, debes cancelar esta tutoría y crear una nueva</small>
        </div>

        <!-- Horarios disponibles del tutor actual -->
        <?php 
        $horarios_tutor = isset($horarios[$tutoria['docente_id']]) ? $horarios[$tutoria['docente_id']] : [];
        ?>

        <?php if (!empty($horarios_tutor)): ?>
        <div class="card" style="background: #f0f8ff; border-left: 4px solid #2c5aa0;">
            <div class="card-header">
                <h3>📅 Horarios Disponibles del Tutor</h3>
            </div>
            <div class="card-body">
                <div class="horarios-grid">
                    <?php
                    $porDia = [];
                    foreach ($horarios_tutor as $h) {
                        if (!isset($porDia[$h['dia_semana']])) {
                            $porDia[$h['dia_semana']] = [];
                        }
                        $porDia[$h['dia_semana']][] = $h;
                    }
                    
                    foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia):
                        if (isset($porDia[$dia])):
                    ?>
                        <div class="horario-dia-card">
                            <strong><?= $dia ?></strong><br>
                            <?php foreach ($porDia[$dia] as $h): ?>
                                <span class="horario-rango"><?= substr($h['hora_inicio'], 0, 5) ?> - <?= substr($h['hora_fin'], 0, 5) ?></span><br>
                            <?php endforeach; ?>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="fecha" class="required">Nueva Fecha</label>
            <input type="date" 
                   id="fecha" 
                   name="fecha" 
                   min="<?= date('Y-m-d') ?>"
                   value="<?= $tutoria['fecha'] ?>"
                   onchange="filtrarHoras()"
                   required>
        </div>

        <div class="form-group">
            <label for="hora" class="required">Nueva Hora</label>
            <select id="hora" name="hora" required>
                <option value="">Selecciona una hora</option>
            </select>
            <small id="hora-ayuda">Selecciona primero la fecha</small>
        </div>

        <div class="form-group">
            <label for="motivo_reprogramacion">Motivo de la Reprogramación (opcional)</label>
            <textarea id="motivo_reprogramacion" 
                      name="motivo_reprogramacion" 
                      rows="3"
                      placeholder="Ej: Conflicto con otro compromiso académico"></textarea>
            <small>Ayuda al tutor a entender por qué reprogramas</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✅ Confirmar Reprogramación</button>
            <a href="index.php?c=tutoria&a=mistutorias" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
const horariosDocente = <?= json_encode($horarios_tutor) ?>;
const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
const horaActual = "<?= $tutoria['hora'] ?>";

function filtrarHoras() {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    
    if (!fechaInput.value) {
        horaSelect.innerHTML = '<option value="">Primero selecciona una fecha</option>';
        return;
    }
    
    const fecha = new Date(fechaInput.value + 'T00:00:00');
    const diaSemana = diasSemana[fecha.getDay()];
    
    // Si no hay horarios disponibles, mostrar todas las horas
    if (horariosDocente.length === 0) {
        horaSelect.innerHTML = `
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
        `;
        return;
    }
    
    // Filtrar horarios del día seleccionado
    const horariosDelDia = horariosDocente.filter(h => h.dia_semana === diaSemana);
    
    if (horariosDelDia.length === 0) {
        horaSelect.innerHTML = '<option value="">No hay horarios disponibles para este día</option>';
        return;
    }
    
    horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
    
    horariosDelDia.forEach(horario => {
        const inicio = horario.hora_inicio.substring(0,5);
        const fin = horario.hora_fin.substring(0,5);
        
        // Generar opciones cada hora dentro del rango
        const [horaIni, minIni] = inicio.split(':').map(Number);
        const [horaFin, minFin] = fin.split(':').map(Number);
        
        for (let h = horaIni; h < horaFin; h++) {
            const horaFormato = h.toString().padStart(2, '0') + ':00:00';
            const horaDisplay = h < 12 ? h + ':00 AM' : (h === 12 ? '12:00 PM' : (h-12) + ':00 PM');
            const selected = (horaFormato === horaActual) ? 'selected' : '';
            horaSelect.innerHTML += `<option value="${horaFormato}" ${selected}>${horaDisplay}</option>`;
        }
    });
}

// Cargar horas al inicio
window.addEventListener('load', filtrarHoras);
</script>

<style>
.horarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 10px;
}

.horario-dia-card {
    padding: 12px;
    background: white;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 0.9rem;
}

.horario-dia-card strong {
    color: #2c5aa0;
    display: block;
    margin-bottom: 8px;
}

.horario-rango {
    display: inline-block;
    padding: 4px 8px;
    background: #e3f2fd;
    border-radius: 4px;
    font-size: 0.85rem;
    margin: 2px 0;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

