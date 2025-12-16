<?php
/**
 * Componente de Breadcrumbs
 * Incluir: <?php include 'views/components/breadcrumb.php'; ?>
 * 
 * Variables requeridas:
 * $breadcrumbs = [
 *     ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=estudiante'],
 *     ['nombre' => 'Tutorías', 'url' => 'index.php?c=tutoria&a=mistutorias'],
 *     ['nombre' => 'Detalle'] // último sin URL
 * ];
 */
?>

<?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
<nav class="breadcrumb-nav" aria-label="Navegación">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">🏠</a>
        </li>
        <?php foreach ($breadcrumbs as $index => $crumb): ?>
            <?php if ($index < count($breadcrumbs) - 1): ?>
                <li class="breadcrumb-item">
                    <a href="<?php echo $crumb['url']; ?>"><?php echo htmlspecialchars($crumb['nombre']); ?></a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo htmlspecialchars($crumb['nombre']); ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>

<style>
.breadcrumb-nav {
    margin-bottom: 1.5rem;
}
.breadcrumb {
    display: flex;
    flex-wrap: wrap;
    padding: 0.75rem 1rem;
    margin: 0;
    list-style: none;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    font-size: 0.9rem;
}
.breadcrumb-item {
    display: flex;
    align-items: center;
}
.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding: 0 0.75rem;
    color: #6c757d;
    font-weight: bold;
}
.breadcrumb-item a {
    color: #2c5aa0;
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb-item a:hover {
    color: #1a3a6c;
    text-decoration: underline;
}
.breadcrumb-item.active {
    color: #495057;
    font-weight: 600;
}
</style>
