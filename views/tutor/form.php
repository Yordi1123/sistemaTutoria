<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2><?php echo isset($tutor) ? 'Editar' : 'Nuevo'; ?> Tutor / Docente</h2>
    
    <form action="index.php?c=tutor&a=<?php echo isset($tutor) ? 'update' : 'save'; ?>" 
          method="POST" class="form">
        
        <?php if (isset($tutor)): ?>
            <input type="hidden" name="id" value="<?php echo $tutor['id']; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" 
                   value="<?php echo isset($tutor) ? htmlspecialchars($tutor['codigo']) : ''; ?>" 
                   placeholder="Ej: DOC001"
                   required>
        </div>
        
        <div class="form-group">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" 
                   value="<?php echo isset($tutor) ? htmlspecialchars($tutor['nombres']) : ''; ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?php echo isset($tutor) ? htmlspecialchars($tutor['apellidos']) : ''; ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="especialidad">Especialidad:</label>
            <input type="text" id="especialidad" name="especialidad" 
                   value="<?php echo isset($tutor) ? htmlspecialchars($tutor['especialidad']) : ''; ?>" 
                   placeholder="Ej: Sistemas, Base de Datos"
                   required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo isset($tutor) ? htmlspecialchars($tutor['email']) : ''; ?>" 
                   placeholder="docente@uns.edu.pe"
                   required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index.php?c=tutor" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'views/layout/footer.php'; ?>
