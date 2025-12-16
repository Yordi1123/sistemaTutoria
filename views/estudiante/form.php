<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=admin'],
    ['nombre' => 'Estudiantes', 'url' => 'index.php?c=estudiante'],
    ['nombre' => isset($estudiante) ? 'Editar' : 'Nuevo']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <h2><?php echo isset($estudiante) ? '✏️ Editar' : '➕ Nuevo'; ?> Estudiante</h2>
    
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <strong>⚠️ Errores de validación:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <form action="index.php?c=estudiante&a=<?php echo isset($estudiante) ? 'update' : 'save'; ?>" 
          method="POST" class="form">
        
        <?php if (isset($estudiante)): ?>
            <input type="hidden" name="id" value="<?php echo $estudiante['id']; ?>">
        <?php endif; ?>
        
        <?php 
        // Datos para el formulario: prioridad a old, luego estudiante, luego vacío
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        ?>
        
        <div class="form-group">
            <label for="codigo">Código: <span class="required">*</span></label>
            <input type="text" id="codigo" name="codigo" 
                   value="<?php echo htmlspecialchars($old['codigo'] ?? ($estudiante['codigo'] ?? '')); ?>" 
                   placeholder="Ej: 0201910001"
                   required>
        </div>
        
        <div class="form-group">
            <label for="nombres">Nombres: <span class="required">*</span></label>
            <input type="text" id="nombres" name="nombres" 
                   value="<?php echo htmlspecialchars($old['nombres'] ?? ($estudiante['nombres'] ?? '')); ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos: <span class="required">*</span></label>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?php echo htmlspecialchars($old['apellidos'] ?? ($estudiante['apellidos'] ?? '')); ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="email">Email: <span class="required">*</span></label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($old['email'] ?? ($estudiante['email'] ?? '')); ?>" 
                   placeholder="estudiante@uns.edu.pe"
                   required>
            <small>Ingresa un correo electrónico válido</small>
        </div>
        
        <div class="form-group">
            <label for="ciclo">Ciclo: <span class="required">*</span></label>
            <input type="number" id="ciclo" name="ciclo" min="1" max="10"
                   value="<?php echo htmlspecialchars($old['ciclo'] ?? ($estudiante['ciclo'] ?? '')); ?>" 
                   required>
            <small>Debe ser un número entre 1 y 10</small>
        </div>
        
        <div class="form-group">
            <label for="escuela">Escuela: <span class="required">*</span></label>
            <input type="text" id="escuela" name="escuela" 
                   value="<?php echo htmlspecialchars($old['escuela'] ?? ($estudiante['escuela'] ?? '')); ?>" 
                   placeholder="Ej: Ingeniería de Sistemas"
                   required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Guardar</button>
            <a href="index.php?c=estudiante" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<style>
.required { color: #ef4444; }
.alert-danger {
    background: #fef2f2;
    border: 1px solid #fee2e2;
    border-left: 4px solid #ef4444;
    color: #991b1b;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}
.alert-danger ul { margin-bottom: 0; }
.form-group small { color: #7f8c8d; font-size: 0.85rem; }
</style>

<?php require_once 'views/layout/footer.php'; ?>
