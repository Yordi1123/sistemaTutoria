<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=admin'],
    ['nombre' => 'Consejeros']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <div class="page-header">
        <h2>🧠 Gestión de Consejeros</h2>
        <p>Administra los consejeros del sistema de bienestar estudiantil</p>
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

    <!-- Barra de acciones y búsqueda -->
    <div class="actions-bar">
        <a href="index.php?c=consejero&a=create" class="btn btn-primary">➕ Nuevo Consejero</a>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Buscar por código, nombre o especialidad..." onkeyup="filtrarTabla()">
        </div>
    </div>

    <div class="table-info">
        <span id="resultCount"><?php echo isset($consejeros) ? count($consejeros) : 0; ?></span> consejeros registrados
    </div>

    <table id="dataTable">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($consejeros)): ?>
                <?php foreach ($consejeros as $consejero): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($consejero['codigo']); ?></strong></td>
                    <td><?php echo htmlspecialchars($consejero['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($consejero['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($consejero['email']); ?></td>
                    <td>
                        <span class="badge badge-purple"><?php echo htmlspecialchars($consejero['especialidad']); ?></span>
                    </td>
                    <td>
                        <a href="index.php?c=consejero&a=edit&id=<?php echo $consejero['id']; ?>" 
                           class="btn-small">✏️ Editar</a>
                        <a href="index.php?c=consejero&a=delete&id=<?php echo $consejero['id']; ?>" 
                           class="btn-small btn-danger"
                           onclick="return confirm('¿Eliminar este consejero? Esta acción no se puede deshacer.')">🗑️ Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem;">
                        No hay consejeros registrados
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
    border-color: #9b59b6;
    outline: none;
}
.table-info {
    color: #7f8c8d;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}
.badge-purple {
    background: #9b59b6;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.85rem;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>
