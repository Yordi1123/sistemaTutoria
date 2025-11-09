<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <h2>Bienvenido al Sistema de Tutoría</h2>
    <p>Gestiona estudiantes, tutores y sesiones de tutoría de manera eficiente.</p>
    
    <div class="cards">
        <div class="card">
            <h3>Estudiantes</h3>
            <p>Administra la información de los estudiantes</p>
            <a href="index.php?c=estudiante" class="btn">Ver Estudiantes</a>
        </div>
        
        <div class="card">
            <h3>Tutores</h3>
            <p>Gestiona los datos de los tutores</p>
            <a href="index.php?c=tutor" class="btn">Ver Tutores</a>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

