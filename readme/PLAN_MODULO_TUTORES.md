# 📋 Plan de Implementación - Módulo de Tutores/Docentes

## 🎯 Objetivo
Implementar funcionalidades completas para que los tutores/docentes puedan gestionar sus tutorías, horarios, estudiantes y generar reportes.

## 📊 Funcionalidades a Implementar

### 1. ✅ Gestionar Disponibilidad Horaria
### 2. ✅ Atender Solicitudes de Tutoría
### 3. ✅ Registrar Seguimiento de Estudiantes
### 4. ✅ Elaborar Fichas de Tutoría
### 5. ✅ Generar Reportes de Avance

---

## 🗂️ Análisis de Base de Datos

### Tablas Existentes:
```sql
✅ docentes           - Datos de tutores/docentes
✅ tutorias          - Registro de tutorías
✅ fichas_tutoria    - Detalles de sesiones realizadas
```

### Tablas a Crear:
```sql
🆕 horarios_docente  - Disponibilidad horaria
🆕 seguimiento       - Seguimiento de estudiantes
```

---

## 📝 Plan de Implementación Detallado

### **FASE 1: Gestionar Disponibilidad Horaria** 🕐
*Prioridad: Alta | Tiempo estimado: 45 min*

#### ¿Qué hace?
Permite al tutor definir sus horarios disponibles para tutorías.

#### Archivos a crear/modificar:
1. **Tabla BD: `horarios_docente`**
   ```sql
   - id
   - docente_id
   - dia_semana (1=Lunes, 2=Martes, etc.)
   - hora_inicio
   - hora_fin
   - estado (activo/inactivo)
   ```

2. **Modelo: `models/HorarioDocente.php`**
   - `create()` - Agregar horario disponible
   - `getByDocente($docente_id)` - Horarios del tutor
   - `getDisponibilidad($docente_id, $dia)` - Por día
   - `update()` - Actualizar horario
   - `delete()` - Eliminar horario
   - `estaDisponible($docente_id, $fecha, $hora)` - Verificar

3. **Controlador: `controllers/HorarioController.php`**
   - `index()` - Ver mis horarios
   - `create()` - Formulario nuevo horario
   - `store()` - Guardar horario
   - `edit($id)` - Formulario editar
   - `update($id)` - Actualizar horario
   - `delete($id)` - Eliminar horario

4. **Vistas:**
   - `views/horario/index.php` - Lista de horarios
   - `views/horario/form.php` - Formulario (crear/editar)

#### Funcionalidad:
```
Tutor define:
- Lunes: 8:00 - 12:00, 14:00 - 18:00
- Martes: 9:00 - 13:00
- Miércoles: 8:00 - 12:00
...
Estudiantes solo pueden solicitar en esos horarios
```

---

### **FASE 2: Atender Solicitudes de Tutoría** 📨
*Prioridad: Alta | Tiempo estimado: 40 min*

#### ¿Qué hace?
El tutor puede ver, aprobar o rechazar solicitudes de tutoría.

#### Archivos a crear/modificar:
1. **Actualizar: `controllers/TutoriaController.php`**
   - `solicitudesDocente()` - Ver solicitudes pendientes
   - `aprobar($id)` - Aprobar solicitud
   - `rechazar($id)` - Rechazar solicitud
   - `tutoriasDocente()` - Todas las tutorías del tutor

2. **Vistas:**
   - `views/tutoria/solicitudes_docente.php` - Solicitudes pendientes
   - `views/tutoria/tutorias_docente.php` - Todas mis tutorías
   - `views/tutoria/modal_aprobar.php` - Modal de confirmación

3. **Actualizar: `models/Tutoria.php`**
   - `getSolicitudesPendientes($docente_id)` - Solo pendientes
   - `aprobar($id, $observaciones)` - Cambiar a confirmada
   - `rechazar($id, $motivo)` - Cambiar a cancelada
   - `countPendientes($docente_id)` - Cantidad pendientes

#### Estados:
```
Estudiante solicita → Pendiente
Tutor aprueba → Confirmada
Tutor rechaza → Cancelada (con motivo)
```

---

### **FASE 3: Registrar Seguimiento de Estudiantes** 👥
*Prioridad: Media | Tiempo estimado: 50 min*

#### ¿Qué hace?
El tutor puede llevar un registro del progreso de cada estudiante.

#### Archivos a crear:
1. **Tabla BD: `seguimiento_estudiantes`**
   ```sql
   - id
   - docente_id
   - estudiante_id
   - fecha
   - tipo (general, academico, personal)
   - descripcion
   - observaciones
   - nivel_avance (bajo, medio, alto)
   - fecha_registro
   ```

2. **Modelo: `models/Seguimiento.php`**
   - `create()` - Crear seguimiento
   - `getByEstudiante($estudiante_id, $docente_id)` - Por estudiante
   - `getMisEstudiantes($docente_id)` - Lista de estudiantes
   - `getResumen($estudiante_id)` - Resumen general
   - `update()` - Actualizar seguimiento
   - `delete()` - Eliminar seguimiento

3. **Controlador: `controllers/SeguimientoController.php`**
   - `misEstudiantes()` - Lista de estudiantes tutorados
   - `verSeguimiento($estudiante_id)` - Historial del estudiante
   - `crear($estudiante_id)` - Formulario nuevo seguimiento
   - `guardar()` - Guardar seguimiento
   - `editar($id)` - Formulario editar
   - `actualizar($id)` - Actualizar seguimiento

4. **Vistas:**
   - `views/seguimiento/estudiantes.php` - Lista de estudiantes
   - `views/seguimiento/ver.php` - Ver seguimiento del estudiante
   - `views/seguimiento/form.php` - Formulario seguimiento

#### Información a registrar:
- Fecha del seguimiento
- Tipo (académico, personal, general)
- Descripción detallada
- Nivel de avance (bajo, medio, alto)
- Observaciones

---

### **FASE 4: Elaborar Fichas de Tutoría** 📝
*Prioridad: Alta | Tiempo estimado: 60 min*

#### ¿Qué hace?
Después de realizar una tutoría, el tutor llena una ficha con los detalles de la sesión.

#### Archivos a crear/modificar:
1. **Tabla existente: `fichas_tutoria`**
   ```sql
   - id
   - tutoria_id
   - problematica
   - acciones
   - conclusiones
   - recomendaciones (agregar)
   - fecha_registro
   ```

2. **Modelo: `models/FichaTutoria.php`**
   - `create()` - Crear ficha
   - `getByTutoria($tutoria_id)` - Ficha de una tutoría
   - `getByDocente($docente_id)` - Todas las fichas del tutor
   - `update()` - Actualizar ficha
   - `existe($tutoria_id)` - Verificar si ya tiene ficha

3. **Controlador: `controllers/FichaController.php`**
   - `crear($tutoria_id)` - Formulario crear ficha
   - `guardar()` - Guardar ficha
   - `ver($id)` - Ver ficha
   - `editar($id)` - Formulario editar
   - `actualizar($id)` - Actualizar ficha
   - `misFichas()` - Todas mis fichas

4. **Vistas:**
   - `views/ficha/form.php` - Formulario ficha
   - `views/ficha/ver.php` - Ver ficha completa
   - `views/ficha/mis_fichas.php` - Lista de fichas del tutor

#### Contenido de la Ficha:
```
1. Información general (auto-llenado)
   - Estudiante
   - Fecha y hora
   - Motivo original

2. Problemática identificada
   - Descripción de la situación
   - Causas detectadas

3. Acciones realizadas
   - Qué se hizo en la sesión
   - Estrategias aplicadas

4. Conclusiones
   - Resultados obtenidos
   - Estado del estudiante

5. Recomendaciones
   - Próximos pasos
   - Seguimiento necesario
```

---

### **FASE 5: Generar Reportes de Avance** 📊
*Prioridad: Media-Alta | Tiempo estimado: 55 min*

#### ¿Qué hace?
El tutor puede generar reportes de sus actividades y del avance de estudiantes.

#### Archivos a crear:
1. **Controlador: `controllers/ReporteController.php`**
   - `misReportes()` - Vista principal de reportes
   - `reporteGeneral()` - Estadísticas generales
   - `reporteEstudiante($id)` - Reporte de un estudiante
   - `reportePeriodo()` - Reporte por periodo
   - `exportarPDF($tipo)` - Exportar a PDF (opcional)

2. **Vistas:**
   - `views/reporte/index.php` - Menú de reportes
   - `views/reporte/general.php` - Reporte general
   - `views/reporte/estudiante.php` - Reporte por estudiante
   - `views/reporte/periodo.php` - Reporte por periodo

3. **Funciones de reportes:**
   - Estadísticas del tutor
   - Tutorías por periodo
   - Estudiantes atendidos
   - Fichas elaboradas
   - Gráficas visuales (con CSS/JS)

#### Tipos de Reportes:
```
1. Reporte General del Tutor:
   - Total de tutorías realizadas
   - Estudiantes únicos atendidos
   - Fichas elaboradas
   - Promedio de sesiones por estudiante
   - Gráfica de tutorías por mes

2. Reporte por Estudiante:
   - Historial de tutorías
   - Fichas asociadas
   - Seguimiento registrado
   - Avance general
   - Recomendaciones

3. Reporte por Periodo:
   - Tutorías en el periodo
   - Estadísticas comparativas
   - Tendencias
```

---

## 🏗️ Estructura de Archivos (Nuevos)

```
sistemaTutoria/
│
├── controllers/
│   ├── HorarioController.php        ✨ NUEVO
│   ├── SeguimientoController.php    ✨ NUEVO
│   ├── FichaController.php          ✨ NUEVO
│   ├── ReporteController.php        ✨ NUEVO
│   └── TutoriaController.php        📝 ACTUALIZAR
│
├── models/
│   ├── HorarioDocente.php           ✨ NUEVO
│   ├── Seguimiento.php              ✨ NUEVO
│   ├── FichaTutoria.php             ✨ NUEVO
│   └── Tutoria.php                  📝 ACTUALIZAR
│
├── views/
│   ├── horario/                     ✨ NUEVA CARPETA
│   │   ├── index.php
│   │   └── form.php
│   │
│   ├── seguimiento/                 ✨ NUEVA CARPETA
│   │   ├── estudiantes.php
│   │   ├── ver.php
│   │   └── form.php
│   │
│   ├── ficha/                       ✨ NUEVA CARPETA
│   │   ├── form.php
│   │   ├── ver.php
│   │   └── mis_fichas.php
│   │
│   ├── reporte/                     ✨ NUEVA CARPETA
│   │   ├── index.php
│   │   ├── general.php
│   │   ├── estudiante.php
│   │   └── periodo.php
│   │
│   ├── tutoria/
│   │   ├── solicitudes_docente.php  ✨ NUEVO
│   │   └── tutorias_docente.php     ✨ NUEVO
│   │
│   └── dashboard/
│       └── docente.php              📝 ACTUALIZAR
│
└── scripts/
    └── actualizar_bd_tutores.sql    ✨ NUEVO
```

---

## 🗄️ Scripts SQL Necesarios

### Script 1: Tabla Horarios
```sql
CREATE TABLE horarios_docente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    docente_id INT NOT NULL,
    dia_semana TINYINT NOT NULL COMMENT '1=Lun, 2=Mar, ..., 7=Dom',
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE CASCADE
) ENGINE=InnoDB;
```

### Script 2: Tabla Seguimiento
```sql
CREATE TABLE seguimiento_estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    docente_id INT NOT NULL,
    estudiante_id INT NOT NULL,
    fecha DATE NOT NULL,
    tipo ENUM('general', 'academico', 'personal') NOT NULL,
    descripcion TEXT NOT NULL,
    observaciones TEXT,
    nivel_avance ENUM('bajo', 'medio', 'alto') DEFAULT 'medio',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (docente_id) REFERENCES docentes(id),
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
) ENGINE=InnoDB;
```

### Script 3: Actualizar Fichas
```sql
ALTER TABLE fichas_tutoria
ADD COLUMN recomendaciones TEXT AFTER conclusiones;
```

---

## 📊 Flujos de Usuario

### 🔄 Flujo 1: Gestionar Horarios
```
1. Docente → Mi Disponibilidad
2. Click "Agregar Horario"
3. Selecciona día de la semana
4. Define hora inicio y hora fin
5. Guarda
6. Sistema muestra en calendario
7. Estudiantes solo pueden solicitar en esos horarios
```

### 🔄 Flujo 2: Atender Solicitudes
```
1. Estudiante solicita tutoría → Estado: Pendiente
2. Docente recibe notificación (visual)
3. Docente → Solicitudes Pendientes
4. Ve detalles de la solicitud:
   - Estudiante
   - Fecha y hora solicitada
   - Motivo
5. Opciones:
   A) Aprobar → Estado: Confirmada
   B) Rechazar → Cancela con motivo
```

### 🔄 Flujo 3: Elaborar Ficha
```
1. Tutoría realizada (asistencia confirmada)
2. Docente → Mis Tutorías
3. Selecciona tutoría "Realizada"
4. Click "Llenar Ficha"
5. Completa formulario:
   - Problemática
   - Acciones
   - Conclusiones
   - Recomendaciones
6. Guarda
7. Ficha queda registrada
8. Estudiante puede verla (opcional)
```

### 🔄 Flujo 4: Seguimiento de Estudiante
```
1. Docente → Mis Estudiantes
2. Ve lista de estudiantes tutorados
3. Selecciona un estudiante
4. Ve historial completo:
   - Tutorías realizadas
   - Fichas elaboradas
   - Seguimientos registrados
5. Puede agregar nuevo seguimiento
6. Registra avance y observaciones
```

### 🔄 Flujo 5: Generar Reporte
```
1. Docente → Reportes
2. Selecciona tipo:
   A) Reporte General
   B) Reporte por Estudiante
   C) Reporte por Periodo
3. Define filtros (fechas, estudiante, etc.)
4. Sistema genera reporte
5. Visualiza en pantalla
6. [Opcional] Exporta a PDF
```

---

## ✅ Checklist de Implementación

### Fase 1: Horarios ⏰
- [ ] Crear tabla horarios_docente
- [ ] Modelo HorarioDocente.php
- [ ] Controlador HorarioController.php
- [ ] Vista index.php (lista de horarios)
- [ ] Vista form.php (crear/editar)
- [ ] Integrar en dashboard docente
- [ ] Validaciones (no solapar horarios)

### Fase 2: Solicitudes 📨
- [ ] Actualizar modelo Tutoria.php
- [ ] Métodos en TutoriaController.php
- [ ] Vista solicitudes_docente.php
- [ ] Vista tutorias_docente.php
- [ ] Aprobar solicitudes
- [ ] Rechazar solicitudes
- [ ] Badge de notificaciones

### Fase 3: Seguimiento 👥
- [ ] Crear tabla seguimiento_estudiantes
- [ ] Modelo Seguimiento.php
- [ ] Controlador SeguimientoController.php
- [ ] Vista estudiantes.php
- [ ] Vista ver.php (historial)
- [ ] Vista form.php (nuevo seguimiento)
- [ ] Estadísticas de avance

### Fase 4: Fichas 📝
- [ ] Actualizar tabla fichas_tutoria
- [ ] Modelo FichaTutoria.php
- [ ] Controlador FichaController.php
- [ ] Vista form.php (llenar ficha)
- [ ] Vista ver.php (ver ficha)
- [ ] Vista mis_fichas.php (lista)
- [ ] Validar que tutoría esté realizada

### Fase 5: Reportes 📊
- [ ] Controlador ReporteController.php
- [ ] Vista index.php (menú)
- [ ] Vista general.php
- [ ] Vista estudiante.php
- [ ] Vista periodo.php
- [ ] Gráficas con CSS/JS
- [ ] Exportar PDF (opcional)

---

## 🔧 Consideraciones Técnicas

### Validaciones
- ✅ Horarios no pueden solaparse
- ✅ Solo el tutor puede aprobar sus solicitudes
- ✅ Ficha solo para tutorías realizadas
- ✅ Seguimiento solo de estudiantes propios
- ✅ Reportes solo de datos propios

### Seguridad
- ✅ Verificar rol de docente
- ✅ Verificar propiedad de recursos
- ✅ Prevenir SQL injection (PDO)
- ✅ Escapar HTML

### Performance
- Índices en tablas nuevas
- Caché de horarios
- Paginación en listados
- Carga optimizada de reportes

---

## 📅 Cronograma Estimado

| Fase | Funcionalidad | Tiempo | Prioridad |
|------|--------------|--------|-----------|
| **1** | Gestionar Horarios | 45 min | Alta |
| **2** | Atender Solicitudes | 40 min | Alta |
| **3** | Seguimiento | 50 min | Media |
| **4** | Fichas de Tutoría | 60 min | Alta |
| **5** | Reportes | 55 min | Media-Alta |
| | **TOTAL** | **4h 10min** | |

---

## 🚀 Orden de Implementación Recomendado

### Sesión 1 (1 hora)
1. ✅ Fase 2: Atender solicitudes (lo más crítico)
2. ✅ Actualizar dashboard docente

### Sesión 2 (1 hora)
1. ✅ Fase 1: Gestionar horarios
2. ✅ Integración con solicitudes

### Sesión 3 (1 hora)
1. ✅ Fase 4: Fichas de tutoría
2. ✅ Validaciones y testing

### Sesión 4 (1 hora)
1. ✅ Fase 3: Seguimiento de estudiantes
2. ✅ Fase 5: Reportes básicos

### Sesión 5 (Opcional - 30 min)
1. ✅ Mejoras UI/UX
2. ✅ Exportar PDF

---

## 🎯 Resultado Final Esperado

### Para el Docente/Tutor:
✅ Dashboard con solicitudes pendientes
✅ Puede gestionar su disponibilidad
✅ Puede aprobar/rechazar solicitudes
✅ Puede ver todas sus tutorías
✅ Puede llenar fichas después de cada sesión
✅ Puede registrar seguimiento de estudiantes
✅ Puede generar reportes de avance
✅ Tiene estadísticas de su trabajo
✅ Puede ver historial de cada estudiante

### Para el Estudiante (Beneficio):
✅ Recibe notificación de aprobación
✅ Puede ver fichas de sus tutorías
✅ Ve el seguimiento que lleva el tutor

### Para el Admin:
✅ Puede ver todos los horarios
✅ Puede ver todas las fichas
✅ Tiene acceso a reportes generales

---

## 📊 Dashboard Docente Actualizado

```
╔══════════════════════════════════════════════════════╗
║  👨‍🏫 Bienvenido, Prof. Juan Pérez           🔔 5     ║
╠══════════════════════════════════════════════════════╣
║                                                      ║
║  📊 MIS ESTADÍSTICAS                                 ║
║  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐  ║
║  │    5    │ │    8    │ │   15    │ │   20    │  ║
║  │Solicitud│ │Tutorías │ │Fichas   │ │Estudian.│  ║
║  │Pendiente│ │  Hoy    │ │Pendiente│ │  Total  │  ║
║  └─────────┘ └─────────┘ └─────────┘ └─────────┘  ║
║                                                      ║
║  🔥 ACCIONES RÁPIDAS                                 ║
║  [📨 Solicitudes] [📅 Mis Tutorías] [📝 Fichas]     ║
║  [⏰ Horarios]    [👥 Estudiantes]  [📊 Reportes]   ║
║                                                      ║
║  ⚠️ SOLICITUDES PENDIENTES (5)                       ║
║  ┌────────────────────────────────────────────────┐ ║
║  │ Carlos Ramirez - Mañana 10am (Sistemas)       │ ║
║  │ [Aprobar] [Rechazar] [Ver Detalle]            │ ║
║  └────────────────────────────────────────────────┘ ║
╚══════════════════════════════════════════════════════╝
```

---

## 📝 Notas Adicionales

- Mantener estructura simple ✅
- Seguir patrón MVC ✅
- Sin librerías externas ✅
- Mobile responsive ✅
- Validaciones completas ✅

---

## 🎉 ¿Listo para Empezar?

**Pregunta:** ¿Quieres que implemente todo el módulo de tutores?

**Recomendación:** Empezar por Fase 2 (Atender solicitudes) ya que es lo más crítico y luego continuar con el resto.

Una vez aprobado el plan, comenzamos la implementación paso a paso. 🚀

---

**NOTA:** Este módulo complementa perfectamente con el módulo de estudiantes ya implementado. Al finalizar, tendremos un sistema completo de gestión de tutorías bidireccional (estudiante ↔ tutor).

