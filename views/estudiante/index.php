<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>Lista de Estudiantes</h2>
    <a href="index.php?c=estudiante&a=create" class="btn btn-primary">Nuevo Estudiante</a>
    
    <table>
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
                    <td><?php echo htmlspecialchars($est['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($est['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($est['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($est['email']); ?></td>
                    <td><?php echo htmlspecialchars($est['ciclo']); ?></td>
                    <td><?php echo htmlspecialchars($est['escuela']); ?></td>
                    <td>
                        <a href="index.php?c=estudiante&a=edit&id=<?php echo $est['id']; ?>" class="btn-small">Editar</a>
                        <a href="index.php?c=estudiante&a=delete&id=<?php echo $est['id']; ?>" 
                           class="btn-small btn-danger" 
                           onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay estudiantes registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/layout/footer.php'; ?>
