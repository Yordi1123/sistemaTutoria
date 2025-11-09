<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2><?php echo isset($estudiante) ? 'Editar' : 'Nuevo'; ?> Estudiante</h2>
    
    <form action="index.php?c=estudiante&a=<?php echo isset($estudiante) ? 'update' : 'save'; ?>" 
          method="POST" class="form">
        
        <?php if (isset($estudiante)): ?>
            <input type="hidden" name="id" value="<?php echo $estudiante['id']; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" 
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['codigo']) : ''; ?>" 
                   placeholder="Ej: 0201910001"
                   required>
        </div>
        
        <div class="form-group">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" 
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['nombres']) : ''; ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['apellidos']) : ''; ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['email']) : ''; ?>" 
                   placeholder="estudiante@uns.edu.pe"
                   required>
        </div>
        
        <div class="form-group">
            <label for="ciclo">Ciclo:</label>
            <input type="number" id="ciclo" name="ciclo" min="1" max="10"
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['ciclo']) : ''; ?>" 
                   required>
        </div>
        
        <div class="form-group">
            <label for="escuela">Escuela:</label>
            <input type="text" id="escuela" name="escuela" 
                   value="<?php echo isset($estudiante) ? htmlspecialchars($estudiante['escuela']) : ''; ?>" 
                   placeholder="Ej: Ingeniería de Sistemas"
                   required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index.php?c=estudiante" class="btn">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'views/layout/footer.php'; ?>
