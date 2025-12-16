<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=admin'],
    ['nombre' => 'Asignaciones']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <div class="page-header">
        <h2>📋 Asignaciones Tutor-Estudiante</h2>
        <p>Gestión de asignaciones permanentes de estudiantes a tutores</p>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Estadísticas -->
    <div class="stats-grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3><?php echo count($asignaciones); ?></h3>
                <p>Estudiantes Asignados</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <h3><?php echo $total_sin_asignar; ?></h3>
                <p>Sin Asignación</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3><?php echo $total_estudiantes; ?></h3>
                <p>Total Estudiantes</p>
            </div>
        </div>
    </div>

    <!-- Barra de acciones y búsqueda -->
    <div class="actions-bar">
        <a href="index.php?c=asignacion&a=create" class="btn btn-primary">➕ Nueva Asignación</a>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Buscar estudiante o tutor..." onkeyup="filtrarTabla()">
        </div>
    </div>

    <?php if ($total_sin_asignar > 0): ?>
    <div class="alert alert-warning" style="margin-bottom: 1.5rem;">
        <strong>⚠️ Atención:</strong> Hay <?php echo $total_sin_asignar; ?> estudiante(s) sin tutor asignado.
        <a href="index.php?c=asignacion&a=create">Asignar ahora</a>
    </div>
    <?php endif; ?>

    <table id="dataTable">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Código</th>
                <th>Ciclo</th>
                <th>Tutor Asignado</th>
                <th>Especialidad</th>
                <th>Fecha Asignación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($asignaciones)): ?>
                <?php foreach ($asignaciones as $asignacion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_apellidos'] . ', ' . $asignacion['estudiante_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_codigo']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['estudiante_ciclo']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['docente_apellidos'] . ', ' . $asignacion['docente_nombres']); ?></td>
                    <td><?php echo htmlspecialchars($asignacion['docente_especialidad']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($asignacion['fecha_asignacion'])); ?></td>
                    <td>
                        <a href="index.php?c=asignacion&a=reasignar&id=<?php echo $asignacion['id']; ?>" 
                           class="btn-small btn-warning" title="Reasignar a otro tutor">🔄 Reasignar</a>
                        <a href="index.php?c=asignacion&a=historial&id=<?php echo $asignacion['estudiante_id']; ?>" 
                           class="btn-small" title="Ver historial">📜 Historial</a>
                        <a href="index.php?c=asignacion&a=delete&id=<?php echo $asignacion['id']; ?>" 
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar esta asignación?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                        No hay asignaciones registradas. <a href="index.php?c=asignacion&a=create">Crear una nueva</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function filtrarTabla() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('dataTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length - 1; j++) {
            if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
                found = true;
                break;
            }
        }
        
        row.style.display = found ? '' : 'none';
    }
}
</script>

<style>
.page-header { margin-bottom: 1.5rem; }
.page-header h2 { color: #2c3e50; margin-bottom: 0.25rem; }
.page-header p { color: #7f8c8d; }
.actions-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}
.search-box input {
    padding: 0.75rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    width: 280px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}
.search-box input:focus {
    border-color: #6366f1;
    outline: none;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}
.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.stat-icon {
    font-size: 2rem;
}
.stat-content h3 {
    margin: 0;
    font-size: 1.5rem;
    color: #2c3e50;
}
.stat-content p {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}
.btn-warning {
    background: #f39c12;
    color: white;
}
.btn-warning:hover {
    background: #e67e22;
}
.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    padding: 1rem;
    border-radius: 8px;
}
.alert-warning a {
    color: #533f03;
    font-weight: bold;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
