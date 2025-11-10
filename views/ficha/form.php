<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2><?= isset($ficha) ? 'Editar' : 'Crear' ?> Ficha de Tutoría</h2>
        <a href="index.php?c=ficha&a=misfichas" class="btn">← Volver</a>
    </div>

    <!-- Información de la tutoría -->
    <div class="card">
        <div class="card-header">
            <h3>Información de la Tutoría</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Fecha:</strong> 
                    <?= isset($ficha) ? date('d/m/Y', strtotime($ficha['tutoria_fecha'])) : date('d/m/Y', strtotime($tutoria['fecha'])) ?>
                </div>
                <div class="info-item">
                    <strong>Hora:</strong> 
                    <?= isset($ficha) ? date('H:i', strtotime($ficha['tutoria_hora'])) : date('H:i', strtotime($tutoria['hora'])) ?>
                </div>
                <div class="info-item">
                    <strong>Estudiante:</strong> 
                    <?= isset($ficha) ? htmlspecialchars($ficha['estudiante_nombres'] . ' ' . $ficha['estudiante_apellidos']) : htmlspecialchars($tutoria['estudiante_nombres'] . ' ' . $tutoria['estudiante_apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Código:</strong> 
                    <?= isset($ficha) ? htmlspecialchars($ficha['estudiante_codigo']) : htmlspecialchars($tutoria['estudiante_codigo']) ?>
                </div>
            </div>
            <div class="info-item" style="margin-top: 15px;">
                <strong>Motivo de la consulta:</strong> 
                <p><?= isset($ficha) ? nl2br(htmlspecialchars($ficha['tutoria_motivo'])) : nl2br(htmlspecialchars($tutoria['motivo'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Errores -->
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

    <!-- Formulario -->
    <form method="POST" action="index.php?c=ficha&a=<?= isset($ficha) ? 'actualizar' : 'guardar' ?>" class="form-card">
        <?php if (isset($ficha)): ?>
            <input type="hidden" name="id" value="<?= $ficha['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="tutoria_id" value="<?= $tutoria['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="problematica" class="required">Problemática Identificada</label>
            <textarea 
                id="problematica" 
                name="problematica" 
                rows="4" 
                required
                placeholder="Describe la problemática o situación identificada durante la tutoría..."
            ><?= isset($ficha) ? htmlspecialchars($ficha['problematica']) : (isset($_SESSION['old']['problematica']) ? htmlspecialchars($_SESSION['old']['problematica']) : '') ?></textarea>
            <small>Detalla la situación académica o personal del estudiante</small>
        </div>

        <div class="form-group">
            <label for="acciones" class="required">Acciones Realizadas</label>
            <textarea 
                id="acciones" 
                name="acciones" 
                rows="4" 
                required
                placeholder="Indica las acciones, recomendaciones o estrategias implementadas..."
            ><?= isset($ficha) ? htmlspecialchars($ficha['acciones']) : (isset($_SESSION['old']['acciones']) ? htmlspecialchars($_SESSION['old']['acciones']) : '') ?></textarea>
            <small>Describe las estrategias y recomendaciones dadas al estudiante</small>
        </div>

        <div class="form-group">
            <label for="conclusiones" class="required">Conclusiones</label>
            <textarea 
                id="conclusiones" 
                name="conclusiones" 
                rows="4" 
                required
                placeholder="Escribe las conclusiones derivadas de la sesión..."
            ><?= isset($ficha) ? htmlspecialchars($ficha['conclusiones']) : (isset($_SESSION['old']['conclusiones']) ? htmlspecialchars($_SESSION['old']['conclusiones']) : '') ?></textarea>
            <small>Resume los aspectos más importantes de la tutoría</small>
        </div>

        <div class="form-group">
            <label for="recomendaciones">Recomendaciones de Seguimiento</label>
            <textarea 
                id="recomendaciones" 
                name="recomendaciones" 
                rows="4"
                placeholder="Indica recomendaciones para próximas sesiones o seguimiento..."
            ><?= isset($ficha) ? htmlspecialchars($ficha['recomendaciones']) : (isset($_SESSION['old']['recomendaciones']) ? htmlspecialchars($_SESSION['old']['recomendaciones']) : '') ?></textarea>
            <small>Sugerencias para el seguimiento posterior del estudiante (opcional)</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= isset($ficha) ? 'Actualizar' : 'Guardar' ?> Ficha
            </button>
            <a href="index.php?c=ficha&a=misfichas" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php 
unset($_SESSION['old']);
require_once 'views/layout/footer.php'; 
?>

