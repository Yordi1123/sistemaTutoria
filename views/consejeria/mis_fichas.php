<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>📝 Mis Fichas de Consejería</h2>
    <p>Registro de todas las fichas de consejería realizadas</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <a href="index.php?c=consejeria&a=dashboard" class="btn">← Volver al Dashboard</a>
    </div>

    <?php if (!empty($fichas)): ?>
        <div class="fichas-list">
            <?php foreach ($fichas as $ficha): ?>
            <div class="ficha-card">
                <div class="ficha-header">
                    <div class="fecha">
                        <span class="dia"><?php echo date('d', strtotime($ficha['consejeria_fecha'])); ?></span>
                        <span class="mes"><?php echo date('M Y', strtotime($ficha['consejeria_fecha'])); ?></span>
                    </div>
                    <div class="estudiante">
                        <h4><?php echo htmlspecialchars($ficha['estudiante_apellidos'] . ', ' . $ficha['estudiante_nombres']); ?></h4>
                        <span class="codigo"><?php echo htmlspecialchars($ficha['estudiante_codigo']); ?></span>
                    </div>
                    <a href="index.php?c=consejeria&a=verFicha&id=<?php echo $ficha['id']; ?>" 
                       class="btn btn-primary btn-small">Ver Ficha</a>
                </div>
                <div class="ficha-preview">
                    <p><strong>Situación:</strong> <?php echo htmlspecialchars(substr($ficha['situacion'], 0, 150)); ?><?php echo strlen($ficha['situacion']) > 150 ? '...' : ''; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📝</div>
            <h3>No tienes fichas registradas</h3>
            <p>Las fichas se crean después de marcar una consejería como realizada.</p>
            <a href="index.php?c=consejeria&a=index" class="btn btn-primary">Ver Mis Consejerías</a>
        </div>
    <?php endif; ?>
</div>

<style>
.fichas-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.ficha-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}
.ficha-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
    color: white;
}
.ficha-header .fecha {
    text-align: center;
    min-width: 60px;
    background: rgba(255,255,255,0.2);
    padding: 0.5rem;
    border-radius: 8px;
}
.ficha-header .fecha .dia {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
}
.ficha-header .fecha .mes {
    font-size: 0.75rem;
    text-transform: uppercase;
}
.ficha-header .estudiante {
    flex: 1;
}
.ficha-header .estudiante h4 {
    margin: 0;
    color: white;
}
.ficha-header .estudiante .codigo {
    opacity: 0.8;
    font-size: 0.9rem;
}
.ficha-header .btn {
    background: white;
    color: #9b59b6;
}
.ficha-preview {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
}
.ficha-preview p {
    margin: 0;
    color: #555;
    font-size: 0.95rem;
}
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
