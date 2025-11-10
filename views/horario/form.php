<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2><?= isset($horario) ? 'Editar' : 'Agregar' ?> Horario de Disponibilidad</h2>
        <a href="index.php?c=horario&a=index" class="btn">← Volver</a>
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

    <form method="POST" action="index.php?c=horario&a=<?= isset($horario) ? 'actualizar' : 'guardar' ?>" class="form-card">
        <?php if (isset($horario)): ?>
            <input type="hidden" name="id" value="<?= $horario['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="dia_semana" class="required">Día de la Semana</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="">Seleccione un día</option>
                <?php 
                $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                foreach ($dias as $dia): 
                    $selected = '';
                    if (isset($horario) && $horario['dia_semana'] == $dia) {
                        $selected = 'selected';
                    } elseif (isset($_SESSION['old']['dia_semana']) && $_SESSION['old']['dia_semana'] == $dia) {
                        $selected = 'selected';
                    }
                ?>
                    <option value="<?= $dia ?>" <?= $selected ?>><?= $dia ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="hora_inicio" class="required">Hora de Inicio</label>
                <input 
                    type="time" 
                    id="hora_inicio" 
                    name="hora_inicio" 
                    value="<?= isset($horario) ? date('H:i', strtotime($horario['hora_inicio'])) : (isset($_SESSION['old']['hora_inicio']) ? $_SESSION['old']['hora_inicio'] : '') ?>" 
                    required
                >
                <small>Formato 24 horas (ej: 14:00)</small>
            </div>

            <div class="form-group">
                <label for="hora_fin" class="required">Hora de Fin</label>
                <input 
                    type="time" 
                    id="hora_fin" 
                    name="hora_fin" 
                    value="<?= isset($horario) ? date('H:i', strtotime($horario['hora_fin'])) : (isset($_SESSION['old']['hora_fin']) ? $_SESSION['old']['hora_fin'] : '') ?>" 
                    required
                >
                <small>Debe ser mayor a la hora de inicio</small>
            </div>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <?php 
                $estado_actual = isset($horario) ? $horario['estado'] : (isset($_SESSION['old']['estado']) ? $_SESSION['old']['estado'] : 'activo');
                ?>
                <option value="activo" <?= $estado_actual == 'activo' ? 'selected' : '' ?>>Activo</option>
                <option value="inactivo" <?= $estado_actual == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
            <small>Los horarios activos están disponibles para solicitudes de tutoría</small>
        </div>

        <!-- Visualización de duración -->
        <div id="duracion-preview" class="info-box" style="display: none;">
            <strong>Duración estimada:</strong> <span id="duracion-text"></span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= isset($horario) ? 'Actualizar' : 'Guardar' ?> Horario
            </button>
            <a href="index.php?c=horario&a=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <!-- Consejos -->
    <div class="card">
        <div class="card-header">
            <h3>💡 Consejos</h3>
        </div>
        <div class="card-body">
            <ul>
                <li>Define bloques de 2 horas para tener suficiente tiempo para cada tutoría</li>
                <li>Evita crear horarios que se solapen entre sí</li>
                <li>Puedes desactivar temporalmente un horario sin eliminarlo</li>
                <li>Considera dejar espacios entre horarios para descanso</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Calcular duración al cambiar las horas
document.getElementById('hora_inicio').addEventListener('change', calcularDuracion);
document.getElementById('hora_fin').addEventListener('change', calcularDuracion);

function calcularDuracion() {
    const inicio = document.getElementById('hora_inicio').value;
    const fin = document.getElementById('hora_fin').value;
    
    if (inicio && fin) {
        const [h1, m1] = inicio.split(':').map(Number);
        const [h2, m2] = fin.split(':').map(Number);
        
        const minutos1 = h1 * 60 + m1;
        const minutos2 = h2 * 60 + m2;
        
        const diferencia = minutos2 - minutos1;
        
        if (diferencia > 0) {
            const horas = Math.floor(diferencia / 60);
            const minutos = diferencia % 60;
            
            let texto = '';
            if (horas > 0) texto += horas + ' hora' + (horas > 1 ? 's' : '');
            if (minutos > 0) texto += (horas > 0 ? ' y ' : '') + minutos + ' minuto' + (minutos > 1 ? 's' : '');
            
            document.getElementById('duracion-text').textContent = texto;
            document.getElementById('duracion-preview').style.display = 'block';
        } else {
            document.getElementById('duracion-preview').style.display = 'none';
        }
    }
}

// Calcular al cargar si hay valores
window.addEventListener('load', calcularDuracion);
</script>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<?php 
unset($_SESSION['old']);
require_once 'views/layout/footer.php'; 
?>

