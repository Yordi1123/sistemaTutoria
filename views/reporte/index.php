<?php require_once 'views/layout/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>📊 Reportes y Estadísticas</h2>
        <a href="index.php?c=dashboard&a=docente" class="btn">← Volver al Dashboard</a>
    </div>

    <!-- Información del docente -->
    <div class="card">
        <div class="card-header">
            <h3>Información del Docente</h3>
        </div>
        <div class="card-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>Nombre:</strong> <?= htmlspecialchars($docente['nombres'] . ' ' . $docente['apellidos']) ?>
                </div>
                <div class="info-item">
                    <strong>Código:</strong> <?= htmlspecialchars($docente['codigo']) ?>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <?= htmlspecialchars($docente['email']) ?>
                </div>
                <div class="info-item">
                    <strong>Especialidad:</strong> <?= htmlspecialchars($docente['especialidad']) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <h3><?= $estadisticas['tutorias']['total'] ?? 0 ?></h3>
                <p>Total Tutorías</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?= $estadisticas['tutorias']['realizadas'] ?? 0 ?></h3>
                <p>Tutorías Realizadas</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">📝</div>
            <div class="stat-content">
                <h3><?= $estadisticas['fichas'] ?></h3>
                <p>Fichas Elaboradas</p>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3><?= $estadisticas['seguimientos'] ?></h3>
                <p>Seguimientos Registrados</p>
            </div>
        </div>

        <div class="stat-card stat-secondary">
            <div class="stat-icon">👨‍🎓</div>
            <div class="stat-content">
                <h3><?= $estadisticas['estudiantes_unicos'] ?></h3>
                <p>Estudiantes Atendidos</p>
            </div>
        </div>

        <div class="stat-card stat-danger">
            <div class="stat-icon">⚠️</div>
            <div class="stat-content">
                <h3><?= $estadisticas['seguimientos_atencion'] ?></h3>
                <p>Casos Prioritarios</p>
            </div>
        </div>
    </div>

    <!-- Tipos de Reportes -->
    <div class="card">
        <div class="card-header">
            <h3>📑 Tipos de Reportes Disponibles</h3>
        </div>
        <div class="card-body">
            <div class="action-grid">
                <a href="index.php?c=reporte&a=general" class="action-card">
                    <div class="action-icon">📈</div>
                    <h4>Reporte General</h4>
                    <p>Todas las tutorías, fichas y seguimientos</p>
                </a>

                <a href="index.php?c=reporte&a=periodo" class="action-card">
                    <div class="action-icon">📅</div>
                    <h4>Reporte por Periodo</h4>
                    <p>Filtrar por mes y año específico</p>
                </a>

                <a href="index.php?c=seguimiento&a=estudiantes" class="action-card">
                    <div class="action-icon">👤</div>
                    <h4>Reporte por Estudiante</h4>
                    <p>Ver historial completo de un estudiante</p>
                </a>

                <a href="index.php?c=reporte&a=riesgo" class="action-card">
                    <div class="action-icon">⚠️</div>
                    <h4>Reporte de Riesgo</h4>
                    <p>Estudiantes que requieren atención</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen Rápido -->
    <div class="card">
        <div class="card-header">
            <h3>📊 Resumen de Actividades</h3>
        </div>
        <div class="card-body">
            <div class="resumen-grid">
                <div class="resumen-item">
                    <div class="resumen-label">Tutorias Pendientes</div>
                    <div class="resumen-value"><?= $estadisticas['tutorias']['pendientes'] ?? 0 ?></div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label">Tutorias Confirmadas</div>
                    <div class="resumen-value"><?= $estadisticas['tutorias']['confirmadas'] ?? 0 ?></div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label">Tutorias Realizadas</div>
                    <div class="resumen-value"><?= $estadisticas['tutorias']['realizadas'] ?? 0 ?></div>
                </div>
                <div class="resumen-item">
                    <div class="resumen-label">Tutorias Canceladas</div>
                    <div class="resumen-value"><?= $estadisticas['tutorias']['canceladas'] ?? 0 ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.resumen-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.resumen-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: center;
}

.resumen-label {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 5px;
}

.resumen-value {
    font-size: 2rem;
    font-weight: bold;
    color: #2c5aa0;
}
</style>

<?php require_once 'views/layout/footer.php'; ?>

