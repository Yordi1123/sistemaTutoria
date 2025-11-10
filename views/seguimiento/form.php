<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2><?= isset($seguimiento) ? 'Editar' : 'Nuevo' ?> Seguimiento</h2>
        <a href="index.php?c=seguimiento&a=ver&id=<?= $estudiante['id'] ?>" class="btn">← Volver</a>
    </div>

    <!-- Información del estudiante -->
    <div class="card">
        <div class="card-header">
            <h3>Estudiante</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Nombre:</strong> <?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Código:</strong> <?= htmlspecialchars($estudiante['codigo']) ?>
                </div>
                <div class="info-item">
                    <strong>Ciclo:</strong> <?= $estudiante['ciclo'] ?>
                </div>
                <div class="info-item">
                    <strong>Escuela:</strong> <?= htmlspecialchars($estudiante['escuela']) ?>
                </div>
            </div>
        </div>
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

    <form method="POST" action="index.php?c=seguimiento&a=<?= isset($seguimiento) ? 'actualizar' : 'guardar' ?>" class="form-card">
        <input type="hidden" name="estudiante_id" value="<?= $estudiante['id'] ?>">
        <?php if (isset($seguimiento)): ?>
            <input type="hidden" name="id" value="<?= $seguimiento['id'] ?>">
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group">
                <label for="fecha" class="required">Fecha</label>
                <input 
                    type="date" 
                    id="fecha" 
                    name="fecha" 
                    value="<?= isset($seguimiento) ? $seguimiento['fecha'] : (isset($_SESSION['old']['fecha']) ? $_SESSION['old']['fecha'] : date('Y-m-d')) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="tipo" class="required">Tipo de Seguimiento</label>
                <select id="tipo" name="tipo" required>
                    <?php 
                    $tipos = [
                        'academico' => 'Académico',
                        'personal' => 'Personal',
                        'conductual' => 'Conductual',
                        'general' => 'General'
                    ];
                    $tipo_sel = isset($seguimiento) ? $seguimiento['tipo'] : (isset($_SESSION['old']['tipo']) ? $_SESSION['old']['tipo'] : 'general');
                    foreach ($tipos as $val => $label): 
                    ?>
                        <option value="<?= $val ?>" <?= $tipo_sel == $val ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="observaciones" class="required">Observaciones</label>
            <textarea 
                id="observaciones" 
                name="observaciones" 
                rows="5" 
                required
                placeholder="Describe la situación observada, comportamiento académico, dificultades identificadas, etc."
            ><?= isset($seguimiento) ? htmlspecialchars($seguimiento['observaciones']) : (isset($_SESSION['old']['observaciones']) ? htmlspecialchars($_SESSION['old']['observaciones']) : '') ?></textarea>
            <small>Detalla las observaciones realizadas durante la sesión</small>
        </div>

        <div class="form-group">
            <label for="recomendaciones">Recomendaciones</label>
            <textarea 
                id="recomendaciones" 
                name="recomendaciones" 
                rows="4"
                placeholder="Recomendaciones para el estudiante o acciones a seguir..."
            ><?= isset($seguimiento) ? htmlspecialchars($seguimiento['recomendaciones']) : (isset($_SESSION['old']['recomendaciones']) ? htmlspecialchars($_SESSION['old']['recomendaciones']) : '') ?></textarea>
            <small>Sugerencias y recomendaciones para mejorar</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="estado_animo">Estado de Ánimo</label>
                <select id="estado_animo" name="estado_animo">
                    <?php 
                    $estados = [
                        'muy_bajo' => '😞 Muy bajo',
                        'bajo' => '😕 Bajo',
                        'normal' => '😐 Normal',
                        'bueno' => '🙂 Bueno',
                        'muy_bueno' => '😊 Muy bueno'
                    ];
                    $estado_sel = isset($seguimiento) ? $seguimiento['estado_animo'] : (isset($_SESSION['old']['estado_animo']) ? $_SESSION['old']['estado_animo'] : 'normal');
                    foreach ($estados as $val => $label): 
                    ?>
                        <option value="<?= $val ?>" <?= $estado_sel == $val ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nivel_avance">Nivel de Avance</label>
                <select id="nivel_avance" name="nivel_avance">
                    <?php 
                    $niveles = [
                        'deficiente' => 'Deficiente',
                        'insuficiente' => 'Insuficiente',
                        'satisfactorio' => 'Satisfactorio',
                        'destacado' => 'Destacado'
                    ];
                    $nivel_sel = isset($seguimiento) ? $seguimiento['nivel_avance'] : (isset($_SESSION['old']['nivel_avance']) ? $_SESSION['old']['nivel_avance'] : 'satisfactorio');
                    foreach ($niveles as $val => $label): 
                    ?>
                        <option value="<?= $val ?>" <?= $nivel_sel == $val ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input 
                    type="checkbox" 
                    name="requiere_atencion" 
                    value="1"
                    <?= (isset($seguimiento) && $seguimiento['requiere_atencion']) ? 'checked' : '' ?>
                    <?= (isset($_SESSION['old']['requiere_atencion'])) ? 'checked' : '' ?>
                >
                <span>⚠️ Este estudiante requiere atención especial</span>
            </label>
            <small>Marca esta opción si el caso requiere seguimiento prioritario</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= isset($seguimiento) ? 'Actualizar' : 'Registrar' ?> Seguimiento
            </button>
            <a href="index.php?c=seguimiento&a=ver&id=<?= $estudiante['id'] ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

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

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
}
</style>

<?php 
unset($_SESSION['old']);
require_once 'views/layout/footer.php'; 
?>

