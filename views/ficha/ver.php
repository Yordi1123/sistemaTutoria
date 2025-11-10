<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Ficha de Tutoría</h2>
        <div>
            <?php if ($_SESSION['rol'] == 'docente'): ?>
                <a href="index.php?c=ficha&a=editar&id=<?= $ficha['id'] ?>" class="btn btn-primary">Editar Ficha</a>
                <a href="index.php?c=ficha&a=misfichas" class="btn">← Volver</a>
            <?php else: ?>
                <a href="javascript:window.print()" class="btn btn-primary">🖨️ Imprimir</a>
                <a href="javascript:history.back()" class="btn">← Volver</a>
            <?php endif; ?>
        </div>
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
                    <?= date('d/m/Y', strtotime($ficha['tutoria_fecha'])) ?>
                </div>
                <div class="info-item">
                    <strong>Hora:</strong> 
                    <?= date('H:i', strtotime($ficha['tutoria_hora'])) ?>
                </div>
                <div class="info-item">
                    <strong>Estudiante:</strong> 
                    <?= htmlspecialchars($ficha['estudiante_nombres'] . ' ' . $ficha['estudiante_apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Código:</strong> 
                    <?= htmlspecialchars($ficha['estudiante_codigo']) ?>
                </div>
                <div class="info-item">
                    <strong>Tutor:</strong> 
                    <?= htmlspecialchars($ficha['docente_nombres'] . ' ' . $ficha['docente_apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Fecha de registro:</strong> 
                    <?= date('d/m/Y H:i', strtotime($ficha['fecha_registro'])) ?>
                </div>
            </div>
            <div class="info-item" style="margin-top: 15px;">
                <strong>Motivo de la consulta:</strong> 
                <p><?= nl2br(htmlspecialchars($ficha['tutoria_motivo'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Contenido de la ficha -->
    <div class="card">
        <div class="card-header">
            <h3>Problemática Identificada</h3>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($ficha['problematica'])) ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Acciones Realizadas</h3>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($ficha['acciones'])) ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Conclusiones</h3>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($ficha['conclusiones'])) ?></p>
        </div>
    </div>

    <?php if (!empty($ficha['recomendaciones'])): ?>
    <div class="card">
        <div class="card-header">
            <h3>Recomendaciones de Seguimiento</h3>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($ficha['recomendaciones'])) ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
@media print {
    .page-header button, .page-header a, .card-header button {
        display: none;
    }
    
    .container {
        max-width: 100%;
    }
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

