<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=estudiante'],
    ['nombre' => 'Tutores Disponibles']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <div class="page-header">
        <h2>👨‍🏫 Tutores Disponibles</h2>
        <p>Consulta la información de los tutores para solicitar tutorías</p>
    </div>

    <!-- Barra de búsqueda -->
    <div class="actions-bar">
        <a href="index.php?c=tutoria&a=solicitar" class="btn btn-primary">📝 Solicitar Tutoría</a>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Buscar por nombre o especialidad..." onkeyup="filtrarTabla()">
        </div>
    </div>

    <div class="table-info">
        <span id="resultCount"><?php echo count($tutores); ?></span> tutores disponibles
    </div>
    
    <table id="dataTable">
        <thead>
            <tr>
                <th>Tutor</th>
                <th>Especialidad</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tutores)): ?>
                <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($tutor['apellidos'] . ', ' . $tutor['nombres']); ?></strong>
                        <br><small class="text-muted"><?php echo htmlspecialchars($tutor['codigo']); ?></small>
                    </td>
                    <td><span class="badge badge-success"><?php echo htmlspecialchars($tutor['especialidad']); ?></span></td>
                    <td><?php echo htmlspecialchars($tutor['email']); ?></td>
                    <td>
                        <a href="index.php?c=tutoria&a=solicitar" class="btn-small btn-primary">📝 Solicitar Tutoría</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">No hay tutores registrados</td>
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
    let visibleCount = 0;
    
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
        if (found) visibleCount++;
    }
    
    document.getElementById('resultCount').textContent = visibleCount;
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
    width: 300px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}
.search-box input:focus {
    border-color: #6366f1;
    outline: none;
}
.table-info {
    color: #7f8c8d;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}
.text-muted { color: #7f8c8d; }
.badge-success {
    background: #27ae60;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.85rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
