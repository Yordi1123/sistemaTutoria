<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>Lista de Tutores / Docentes</h2>
    <a href="index.php?c=tutor&a=create" class="btn btn-primary">Nuevo Tutor</a>
    
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Especialidad</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tutores)): ?>
                <?php foreach ($tutores as $tutor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tutor['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['especialidad']); ?></td>
                    <td><?php echo htmlspecialchars($tutor['email']); ?></td>
                    <td>
                        <a href="index.php?c=tutor&a=edit&id=<?php echo $tutor['id']; ?>" class="btn-small">Editar</a>
                        <a href="index.php?c=tutor&a=delete&id=<?php echo $tutor['id']; ?>" 
                           class="btn-small btn-danger" 
                           onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay tutores registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'views/layout/footer.php'; ?>
