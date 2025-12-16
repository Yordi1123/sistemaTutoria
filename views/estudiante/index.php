<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=admin'],
    ['nombre' => 'Estudiantes']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <div class="page-header">
        <h2>👨‍🎓 Lista de Estudiantes</h2>
    </div>

    <!-- Barra de acciones y búsqueda -->
    <div class="actions-bar">
        <a href="index.php?c=estudiante&a=create" class="btn btn-primary">➕ Nuevo Estudiante</a>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Buscar por código, nombre o email..." onkeyup="filtrarTabla()">
        </div>
    </div>

    <div class="table-info">
        <span id="resultCount"><?php echo count($estudiantes); ?></span> estudiantes registrados
    </div>
    
    <table id="dataTable">
        <thead>
            <tr>
                <th>Código</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>Ciclo</th>
                <th>Escuela</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estudiantes)): ?>
                <?php foreach ($estudiantes as $est): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($est['codigo']); ?></strong></td>
                    <td><?php echo htmlspecialchars($est['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($est['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($est['email']); ?></td>
                    <td><span class="badge badge-info"><?php echo htmlspecialchars($est['ciclo']); ?></span></td>
                    <td><?php echo htmlspecialchars($est['escuela']); ?></td>
                    <td>
                        <a href="index.php?c=estudiante&a=edit&id=<?php echo $est['id']; ?>" class="btn-small">✏️ Editar</a>
                        <a href="index.php?c=estudiante&a=delete&id=<?php echo $est['id']; ?>" 
                           class="btn-small btn-danger" 
                           onclick="return confirm('¿Estás seguro de eliminar a este estudiante?')">🗑️ Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">No hay estudiantes registrados</td>
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
        
        for (let j = 0; j < cells.length - 1; j++) { // Excluir columna acciones
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
.page-header h2 { color: #2c3e50; }
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
.badge-info {
    background: #3498db;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.85rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
