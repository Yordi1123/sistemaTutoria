<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Estudiantes - Seguimiento</h2>
        <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>👨‍🎓 Lista de Estudiantes</h3>
        </div>
        <div class="card-body">
            <?php if (empty($estudiantes)): ?>
                <div class="empty-state">
                    <p>No hay estudiantes registrados</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Estudiante</th>
                                <th>Escuela</th>
                                <th>Ciclo</th>
                                <th>Último Seguimiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $estudiante): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($estudiante['codigo']) ?></strong></td>
                                <td><?= htmlspecialchars($estudiante['nombres'] . ' ' . $estudiante['apellidos']) ?></td>
                                <td><?= htmlspecialchars($estudiante['escuela']) ?></td>
                                <td><?= $estudiante['ciclo'] ?></td>
                                <td>
                                    <?php if ($estudiante['ultimo_seguimiento']): ?>
                                        <?= date('d/m/Y', strtotime($estudiante['ultimo_seguimiento']['fecha'])) ?>
                                        <br>
                                        <small>
                                            <?php if ($estudiante['ultimo_seguimiento']['requiere_atencion']): ?>
                                                <span class="badge badge-danger">⚠️ Requiere atención</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">✓ Normal</span>
                                            <?php endif; ?>
                                        </small>
                                    <?php else: ?>
                                        <small class="text-muted">Sin seguimiento</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?c=seguimiento&a=ver&id=<?= $estudiante['id'] ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Ver seguimiento">
                                        👁️ Ver
                                    </a>
                                    <a href="index.php?c=seguimiento&a=crear&id=<?= $estudiante['id'] ?>" 
                                       class="btn btn-sm btn-success" 
                                       title="Nuevo seguimiento">
                                        ➕ Registrar
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

