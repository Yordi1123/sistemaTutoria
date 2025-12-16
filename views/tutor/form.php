<?php require_once 'views/layout/header.php'; ?>

<?php
$breadcrumbs = [
    ['nombre' => 'Dashboard', 'url' => 'index.php?c=dashboard&a=admin'],
    ['nombre' => 'Tutores', 'url' => 'index.php?c=tutor'],
    ['nombre' => isset($tutor) ? 'Editar' : 'Nuevo']
];
include 'views/components/breadcrumb.php';
?>

<div class="container">
    <h2><?php echo isset($tutor) ? '✏️ Editar' : '➕ Nuevo'; ?> Tutor / Docente</h2>
    
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
    
    <form action="index.php?c=tutor&a=<?php echo isset($tutor) ? 'update' : 'save'; ?>" 
          method="POST" class="form">
        
        <?php if (isset($tutor)): ?>
            <input type="hidden" name="id" value="<?php echo $tutor['id']; ?>">
        <?php endif; ?>
        
        <?php 
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        ?>
        
        <div class="form-group">
            <label for="codigo">Código: <span class="required">*</span></label>
            <input type="text" id="codigo" name="codigo" 
                   value="<?php echo htmlspecialchars($old['codigo'] ?? ($tutor['codigo'] ?? '')); ?>" 
                   placeholder="Ej: DOC001"
                   required>
        </div>
        
        <div class="form-group">
            <label for="nombres">Nombres: <span class="required">*</span></label>
            <input type="text" id="nombres" name="nombres" 
                   value="<?php echo htmlspecialchars($old['nombres'] ?? ($tutor['nombres'] ?? '')); ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos: <span class="required">*</span></label>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?php echo htmlspecialchars($old['apellidos'] ?? ($tutor['apellidos'] ?? '')); ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="especialidad">Especialidad: <span class="required">*</span></label>
            <input type="text" id="especialidad" name="especialidad" 
                   value="<?php echo htmlspecialchars($old['especialidad'] ?? ($tutor['especialidad'] ?? '')); ?>" 
                   placeholder="Ej: Sistemas, Base de Datos"
                   required>
        </div>
        
        <div class="form-group">
            <label for="email">Email: <span class="required">*</span></label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($old['email'] ?? ($tutor['email'] ?? '')); ?>" 
                   placeholder="docente@uns.edu.pe"
                   required>
            <small>Ingresa un correo electrónico válido</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Guardar</button>
            <a href="index.php?c=tutor" class="btn btn-secondary">Cancelar</a>
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
