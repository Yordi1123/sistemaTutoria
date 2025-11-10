<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Gestión de Disponibilidad Horaria</h2>
        <div>
            <a href="index.php?c=horario&a=crear" class="btn btn-primary">➕ Agregar Horario</a>
            <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Resumen de Horarios -->
    <div class="card">
        <div class="card-header">
            <h3>📅 Resumen Semanal</h3>
        </div>
        <div class="card-body">
            <?php if (empty($horariosAgrupados)): ?>
                <div class="empty-state">
                    <p>No has registrado horarios de disponibilidad</p>
                    <p class="text-muted">Agrega tus horarios disponibles para que los estudiantes puedan solicitar tutorías</p>
                    <a href="index.php?c=horario&a=crear" class="btn btn-primary">➕ Agregar mi primer horario</a>
                </div>
            <?php else: ?>
                <div class="horarios-resumen">
                    <?php foreach ($horariosAgrupados as $dia): ?>
                        <div class="horario-dia">
                            <strong><?= htmlspecialchars($dia['dia_semana']) ?>:</strong>
                            <span><?= htmlspecialchars($dia['horarios']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabla de Horarios Detallada -->
    <?php if (!empty($horarios)): ?>
    <div class="card">
        <div class="card-header">
            <h3>📋 Lista Detallada de Horarios</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($horarios as $horario): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($horario['dia_semana']) ?></strong></td>
                            <td><?= date('H:i', strtotime($horario['hora_inicio'])) ?></td>
                            <td><?= date('H:i', strtotime($horario['hora_fin'])) ?></td>
                            <td>
                                <?php
                                    $inicio = new DateTime($horario['hora_inicio']);
                                    $fin = new DateTime($horario['hora_fin']);
                                    $duracion = $inicio->diff($fin);
                                    echo $duracion->h . 'h ' . ($duracion->i > 0 ? $duracion->i . 'min' : '');
                                ?>
                            </td>
                            <td>
                                <?php if ($horario['estado'] == 'activo'): ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?c=horario&a=editar&id=<?= $horario['id'] ?>" 
                                   class="btn btn-sm btn-primary" 
                                   title="Editar">
                                    ✏️ Editar
                                </a>
                                
                                <?php if ($horario['estado'] == 'activo'): ?>
                                    <a href="index.php?c=horario&a=cambiarEstado&id=<?= $horario['id'] ?>&estado=inactivo" 
                                       class="btn btn-sm btn-warning" 
                                       title="Desactivar"
                                       onclick="return confirm('¿Desactivar este horario?')">
                                        ⏸️ Desactivar
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?c=horario&a=cambiarEstado&id=<?= $horario['id'] ?>&estado=activo" 
                                       class="btn btn-sm btn-success" 
                                       title="Activar"
                                       onclick="return confirm('¿Activar este horario?')">
                                        ▶️ Activar
                                    </a>
                                <?php endif; ?>
                                
                                <a href="index.php?c=horario&a=eliminar&id=<?= $horario['id'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   title="Eliminar"
                                   onclick="return confirm('¿Estás seguro de eliminar este horario?')">
                                    🗑️ Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Ayuda -->
    <div class="card">
        <div class="card-header">
            <h3>ℹ️ Información</h3>
        </div>
        <div class="card-body">
            <ul>
                <li><strong>Horarios activos:</strong> Los estudiantes pueden solicitar tutorías en estos horarios</li>
                <li><strong>Horarios inactivos:</strong> No están disponibles para solicitudes</li>
                <li><strong>Evita solapamientos:</strong> No puedes crear horarios que se solapen entre sí</li>
                <li><strong>Gestión flexible:</strong> Puedes activar/desactivar horarios según tu disponibilidad</li>
            </ul>
        </div>
    </div>
</div>

<style>
.horarios-resumen {
    display: grid;
    gap: 10px;
}

.horario-dia {
    display: flex;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}

.horario-dia strong {
    min-width: 100px;
    color: #2c5aa0;
}

.horario-dia span {
    color: #666;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

