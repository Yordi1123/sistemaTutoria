<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>Mis Fichas de Tutoría</h2>
        <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
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

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($fichas) ?></div>
            <div class="stat-label">Total de Fichas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                    $ultimas30dias = array_filter($fichas, function($f) {
                        return strtotime($f['fecha_registro']) > strtotime('-30 days');
                    });
                    echo count($ultimas30dias);
                ?>
            </div>
            <div class="stat-label">Últimos 30 días</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                <?php 
                    $esteMes = array_filter($fichas, function($f) {
                        return date('Y-m', strtotime($f['fecha_registro'])) == date('Y-m');
                    });
                    echo count($esteMes);
                ?>
            </div>
            <div class="stat-label">Este mes</div>
        </div>
    </div>

    <!-- Lista de fichas -->
    <div class="card">
        <div class="card-header">
            <h3>Fichas Registradas</h3>
        </div>
        <div class="card-body">
            <?php if (empty($fichas)): ?>
                <div class="empty-state">
                    <p>No tienes fichas registradas</p>
                    <a href="index.php?c=tutoria&a=mistutoriasdocente" class="btn btn-primary">
                        Ver tutorías para llenar fichas
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha Tutoría</th>
                                <th>Estudiante</th>
                                <th>Código</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fichas as $ficha): ?>
                            <tr>
                                <td>
                                    <strong><?= date('d/m/Y', strtotime($ficha['tutoria_fecha'])) ?></strong><br>
                                    <small><?= date('H:i', strtotime($ficha['tutoria_hora'])) ?></small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($ficha['estudiante_nombres'] . ' ' . $ficha['estudiante_apellidos']) ?>
                                </td>
                                <td><?= htmlspecialchars($ficha['estudiante_codigo']) ?></td>
                                <td>
                                    <?= date('d/m/Y', strtotime($ficha['fecha_registro'])) ?><br>
                                    <small><?= date('H:i', strtotime($ficha['fecha_registro'])) ?></small>
                                </td>
                                <td>
                                    <a href="index.php?c=ficha&a=ver&id=<?= $ficha['id'] ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Ver ficha">
                                        👁️ Ver
                                    </a>
                                    <a href="index.php?c=ficha&a=editar&id=<?= $ficha['id'] ?>" 
                                       class="btn btn-sm btn-secondary" 
                                       title="Editar ficha">
                                        ✏️ Editar
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

