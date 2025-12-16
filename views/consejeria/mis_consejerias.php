<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>🧠 Mis Consejerías</h2>
    <p>Historial de tus citas con el servicio de consejería</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=consejeria&a=solicitar" class="btn btn-primary">➕ Nueva Solicitud</a>
        <a href="index.php?c=dashboard&a=estudiante" class="btn">← Volver al Dashboard</a>
    </div>

    <?php if (!empty($consejerias)): ?>
        <div class="consejerias-list">
            <?php foreach ($consejerias as $consejeria): ?>
            <div class="consejeria-card">
                <div class="consejeria-fecha">
                    <span class="dia"><?php echo date('d', strtotime($consejeria['fecha'])); ?></span>
                    <span class="mes"><?php echo date('M', strtotime($consejeria['fecha'])); ?></span>
                </div>
                <div class="consejeria-info">
                    <h4>Consejería con <?php echo htmlspecialchars($consejeria['consejero_nombres'] . ' ' . $consejeria['consejero_apellidos']); ?></h4>
                    <p class="especialidad"><?php echo htmlspecialchars($consejeria['consejero_especialidad']); ?></p>
                    <p class="hora">🕐 <?php echo date('h:i A', strtotime($consejeria['hora'])); ?></p>
                    <p class="motivo"><?php echo htmlspecialchars(substr($consejeria['motivo'], 0, 100)); ?><?php echo strlen($consejeria['motivo']) > 100 ? '...' : ''; ?></p>
                </div>
                <div class="consejeria-estado">
                    <?php
                    $badge_class = '';
                    $icon = '';
                    switch($consejeria['estado']) {
                        case 'pendiente': $badge_class = 'badge-warning'; $icon = '⏳'; break;
                        case 'confirmada': $badge_class = 'badge-info'; $icon = '✓'; break;
                        case 'realizada': $badge_class = 'badge-success'; $icon = '✅'; break;
                        case 'cancelada': $badge_class = 'badge-danger'; $icon = '❌'; break;
                    }
                    ?>
                    <span class="badge <?php echo $badge_class; ?>"><?php echo $icon . ' ' . ucfirst($consejeria['estado']); ?></span>
                    <?php if ($consejeria['estado'] == 'pendiente'): ?>
                        <a href="index.php?c=consejeria&a=cancelar&id=<?php echo $consejeria['id']; ?>" 
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Cancelar esta consejería?')">Cancelar</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">🧠</div>
            <h3>No tienes consejerías registradas</h3>
            <p>Solicita una cita con el servicio de consejería para recibir orientación.</p>
            <a href="index.php?c=consejeria&a=solicitar" class="btn btn-primary">Solicitar Consejería</a>
        </div>
    <?php endif; ?>
</div>

<style>
.consejerias-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.consejeria-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 1.5rem;
    display: flex;
    gap: 1.5rem;
    align-items: center;
}
.consejeria-fecha {
    text-align: center;
    min-width: 60px;
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
    color: white;
    padding: 0.75rem;
    border-radius: 10px;
}
.consejeria-fecha .dia {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
}
.consejeria-fecha .mes {
    font-size: 0.85rem;
    text-transform: uppercase;
}
.consejeria-info {
    flex: 1;
}
.consejeria-info h4 {
    margin: 0 0 0.25rem;
    color: #2c3e50;
}
.consejeria-info .especialidad {
    color: #9b59b6;
    margin: 0 0 0.5rem;
    font-weight: 600;
}
.consejeria-info .hora {
    color: #7f8c8d;
    margin: 0 0 0.25rem;
    font-size: 0.9rem;
}
.consejeria-info .motivo {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.9rem;
}
.consejeria-estado {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
}
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
}
.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #cfe2ff; color: #084298; }
.badge-success { background: #d1e7dd; color: #0f5132; }
.badge-danger { background: #f8d7da; color: #842029; }
.empty-state {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 12px;
}
.empty-icon { font-size: 4rem; margin-bottom: 1rem; }
.empty-state h3 { color: #2c3e50; margin-bottom: 0.5rem; }
.empty-state p { color: #7f8c8d; margin-bottom: 1rem; }
</style>

<?php require_once 'views/layout/footer.php'; ?>
