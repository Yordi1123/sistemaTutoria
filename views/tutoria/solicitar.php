<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=estudiante'],
    ['nombre' => 'Solicitar Tutoría']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <div class="page-header">
        <h2>📝 Solicitar Tutoría</h2>
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

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Instrucciones -->
    <div class="card">
        <div class="card-header">
            <h3>ℹ️ Instrucciones</h3>
        </div>
        <div class="card-body">
            <ol>
                <li><strong>Selecciona un tutor</strong> para ver su disponibilidad horaria</li>
                <li><strong>Elige el día</strong> que mejor se adapte a tu horario</li>
                <li><strong>Selecciona la hora</strong> dentro de los horarios disponibles del tutor</li>
                <li><strong>Describe el motivo</strong> para que el tutor pueda prepararse mejor</li>
            </ol>
        </div>
    </div>

    <form action="index.php?c=tutoria&a=guardar" method="POST" class="form-card">
        
        <div class="form-group">
            <label for="docente_id" class="required">Tutor / Docente</label>
            <select id="docente_id" name="docente_id" required onchange="cargarHorarios()">
                <option value="">Selecciona un tutor</option>
                <?php foreach ($tutores as $tutor): ?>
                    <option value="<?= $tutor['id'] ?>" 
                            data-horarios='<?= isset($horarios[$tutor['id']]) ? json_encode($horarios[$tutor['id']]) : '[]' ?>'
                            <?= (isset($_SESSION['old']['docente_id']) && $_SESSION['old']['docente_id'] == $tutor['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tutor['apellidos'] . ', ' . $tutor['nombres']) ?> 
                        - <?= htmlspecialchars($tutor['especialidad']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Horarios disponibles -->
        <div id="horarios-disponibles" style="display: none;">
            <div class="card" style="background: #f0f8ff; border-left: 4px solid #2c5aa0;">
                <div class="card-header">
                    <h3>📅 Horarios Disponibles</h3>
                </div>
                <div class="card-body">
                    <div id="horarios-contenido"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="fecha" class="required">Fecha</label>
            
            <!-- Quick Date Selection -->
            <div class="mini-calendar">
                <p style="margin-bottom: 0.5rem; color: #666;">📅 Selección rápida (próximos 7 días):</p>
                <div class="quick-dates" id="quick-dates">
                    <?php
                    $diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                    for ($i = 0; $i < 7; $i++) {
                        $fecha = date('Y-m-d', strtotime("+$i days"));
                        $diaSemana = $diasSemana[date('w', strtotime($fecha))];
                        $diaNum = date('d', strtotime($fecha));
                        $mes = date('M', strtotime($fecha));
                    ?>
                    <button type="button" 
                            class="quick-date-btn" 
                            data-fecha="<?= $fecha ?>"
                            onclick="seleccionarFecha('<?= $fecha ?>')">
                        <span class="day-name"><?= $diaSemana ?></span>
                        <span class="day-num"><?= $diaNum ?></span>
                        <small><?= $mes ?></small>
                    </button>
                    <?php } ?>
                </div>
            </div>
            
            <input type="date" 
                   id="fecha" 
                   name="fecha" 
                   min="<?= date('Y-m-d') ?>"
                   value="<?= isset($_SESSION['old']['fecha']) ? htmlspecialchars($_SESSION['old']['fecha']) : '' ?>"
                   onchange="filtrarHorasPorDia(); actualizarBotonesRapidos();"
                   required>
            <small>O selecciona otra fecha en el calendario</small>
        </div>

        <div class="form-group">
            <label for="hora" class="required">Hora</label>
            <select id="hora" name="hora" required disabled>
                <option value="">Primero selecciona un tutor y fecha</option>
            </select>
            <small id="hora-ayuda">Las horas disponibles dependen del horario del tutor</small>
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
            <a href="index.php?c=dashboard&a=estudiante" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <?php unset($_SESSION['old']); ?>
</div>

<script>
let horariosDocente = [];
const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

function cargarHorarios() {
    const select = document.getElementById('docente_id');
    const option = select.options[select.selectedIndex];
    
    if (select.value === '') {
        document.getElementById('horarios-disponibles').style.display = 'none';
        document.getElementById('hora').disabled = true;
        document.getElementById('hora').innerHTML = '<option value="">Primero selecciona un tutor y fecha</option>';
        horariosDocente = [];
        return;
    }
    
    try {
        horariosDocente = JSON.parse(option.dataset.horarios || '[]');
        mostrarHorariosDisponibles();
        filtrarHorasPorDia();
    } catch (e) {
        console.error('Error al cargar horarios:', e);
        horariosDocente = [];
    }
}

function mostrarHorariosDisponibles() {
    const contenedor = document.getElementById('horarios-contenido');
    
    if (horariosDocente.length === 0) {
        contenedor.innerHTML = '<p class="text-muted">⚠️ Este tutor aún no ha configurado sus horarios disponibles. Puedes solicitar la tutoría de todos modos.</p>';
        document.getElementById('horarios-disponibles').style.display = 'block';
        return;
    }
    
    // Agrupar por día
    const porDia = {};
    horariosDocente.forEach(h => {
        if (!porDia[h.dia_semana]) {
            porDia[h.dia_semana] = [];
        }
        porDia[h.dia_semana].push(h);
    });
    
    let html = '<div class="horarios-grid">';
    ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'].forEach(dia => {
        if (porDia[dia]) {
            html += `<div class="horario-dia-card">
                <strong>${dia}</strong><br>`;
            porDia[dia].forEach(h => {
                html += `<span class="horario-rango">${h.hora_inicio.substring(0,5)} - ${h.hora_fin.substring(0,5)}</span><br>`;
            });
            html += '</div>';
        }
    });
    html += '</div>';
    
    contenedor.innerHTML = html;
    document.getElementById('horarios-disponibles').style.display = 'block';
}

function filtrarHorasPorDia() {
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    
    if (!fechaInput.value || horariosDocente.length === 0) {
        horaSelect.disabled = false;
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
    
    const fecha = new Date(fechaInput.value + 'T00:00:00');
    const diaSemana = diasSemana[fecha.getDay()];
    
    // Filtrar horarios del día seleccionado
    const horariosDelDia = horariosDocente.filter(h => h.dia_semana === diaSemana);
    
    if (horariosDelDia.length === 0) {
        horaSelect.innerHTML = '<option value="">No hay horarios disponibles para este día</option>';
        horaSelect.disabled = true;
        return;
    }
    
    horaSelect.disabled = false;
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
            horaSelect.innerHTML += `<option value="${horaFormato}">${horaDisplay}</option>`;
        }
    });
}

// Cargar horarios si hay un docente preseleccionado
window.addEventListener('load', function() {
    const docenteSelect = document.getElementById('docente_id');
    if (docenteSelect.value) {
        cargarHorarios();
    }
    actualizarBotonesRapidos();
});

// Seleccionar fecha desde botones rápidos
function seleccionarFecha(fecha) {
    document.getElementById('fecha').value = fecha;
    filtrarHorasPorDia();
    actualizarBotonesRapidos();
}

// Actualizar estado visual de botones rápidos
function actualizarBotonesRapidos() {
    const fechaSeleccionada = document.getElementById('fecha').value;
    document.querySelectorAll('.quick-date-btn').forEach(btn => {
        if (btn.dataset.fecha === fechaSeleccionada) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}
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
    cursor: pointer;
    transition: all 0.2s;
}

.horario-dia-card:hover {
    border-color: #2c5aa0;
    box-shadow: 0 2px 8px rgba(44, 90, 160, 0.2);
}

.horario-dia-card.selected {
    border-color: #2c5aa0;
    background: #e3f2fd;
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

/* Visual Mini Calendar */
.mini-calendar {
    margin: 1rem 0;
}
.quick-dates {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 1rem;
}
.quick-date-btn {
    padding: 8px 16px;
    border: 2px solid #e0e0e0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s;
}
.quick-date-btn:hover {
    border-color: #2c5aa0;
    background: #f0f7ff;
}
.quick-date-btn.active {
    border-color: #2c5aa0;
    background: #2c5aa0;
    color: white;
}
.quick-date-btn .day-name {
    display: block;
    font-weight: bold;
}
.quick-date-btn .day-num {
    font-size: 1.1rem;
}

/* Enhanced date input */
input[type="date"] {
    padding: 12px;
    font-size: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    width: 100%;
    transition: border-color 0.2s;
}
input[type="date"]:focus {
    border-color: #2c5aa0;
    outline: none;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

