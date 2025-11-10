# 📋 IMPLEMENTACIÓN MÓDULO DE TUTORES

**Sistema de Tutoría y Consejería - UNS**  
**Fecha:** 10/11/2025

---

## 📌 RESUMEN

Este documento detalla la implementación del **Módulo de Tutores**, que permite a los docentes gestionar solicitudes de tutoría, atender estudiantes, llenar fichas de seguimiento y visualizar estadísticas de su trabajo tutorial.

---

## 🎯 FUNCIONALIDADES IMPLEMENTADAS

### ✅ FASE 2: Atender Solicitudes de Tutoría

**Descripción:** Los tutores pueden ver, aprobar o rechazar solicitudes de tutoría enviadas por estudiantes.

#### Archivos Modificados/Creados:

1. **`models/Tutoria.php`** - Métodos agregados:
   - `getSolicitudesPendientes($docente_id)` - Obtiene solicitudes pendientes
   - `countPendientes($docente_id)` - Cuenta solicitudes pendientes
   - `aprobar($id)` - Aprueba una solicitud
   - `rechazar($id)` - Rechaza una solicitud
   - `getTutoriasHoyDocente($docente_id)` - Tutorías del día del docente
   - `getProximasDocente($docente_id)` - Próximas tutorías del docente
   - `getEstadisticasDocente($docente_id)` - Estadísticas del docente
   - `getEstudiantesUnicos($docente_id)` - Cantidad de estudiantes atendidos
   - `perteneceADocente($tutoria_id, $docente_id)` - Verifica propiedad

2. **`controllers/TutoriaController.php`** - Métodos agregados:
   - `solicitudes()` - Vista de solicitudes pendientes
   - `aprobar()` - Aprueba una solicitud
   - `rechazar()` - Rechaza una solicitud
   - `mistutoriasdocente()` - Lista todas las tutorías del docente

3. **`views/tutoria/solicitudes_docente.php`** (NUEVO)
   - Muestra solicitudes pendientes en una tabla
   - Permite aprobar o rechazar solicitudes
   - Muestra información del estudiante y motivo

4. **`views/tutoria/tutorias_docente.php`** (NUEVO)
   - Lista completa de tutorías del docente
   - Filtrado por estado
   - Contadores de tutorías por estado
   - Opciones para llenar fichas de tutorías realizadas

#### Flujo de Trabajo:

```
1. Estudiante solicita tutoría (estado: pendiente)
2. Docente ve solicitud en su dashboard o en "Solicitudes"
3. Docente puede:
   - ✅ Aprobar → Estado cambia a "confirmada"
   - ❌ Rechazar → Estado cambia a "cancelada"
4. Tutoría confirmada aparece en "Mis Tutorías"
5. Al llegar la fecha, docente puede marcar como "realizada"
6. Docente puede llenar ficha de tutoría
```

---

### ✅ FASE 4: Elaborar Fichas de Tutoría

**Descripción:** Los tutores pueden llenar fichas detalladas de las tutorías realizadas, registrando problemática, acciones, conclusiones y recomendaciones.

#### Archivos Creados:

1. **`models/FichaTutoria.php`** (NUEVO)
   - `create()` - Crea una nueva ficha
   - `update()` - Actualiza una ficha existente
   - `getByTutoria($tutoria_id)` - Obtiene ficha por ID de tutoría
   - `getById($id)` - Obtiene ficha por ID
   - `getByDocente($docente_id)` - Fichas de un docente
   - `getByEstudiante($estudiante_id)` - Fichas de un estudiante
   - `existe($tutoria_id)` - Verifica si existe ficha
   - `countByDocente($docente_id)` - Cuenta fichas del docente

2. **`controllers/FichaController.php`** (NUEVO)
   - `crear()` - Muestra formulario de nueva ficha
   - `guardar()` - Guarda nueva ficha
   - `ver()` - Visualiza una ficha
   - `editar()` - Muestra formulario de edición
   - `actualizar()` - Actualiza ficha existente
   - `misfichas()` - Lista todas las fichas del docente

3. **`views/ficha/form.php`** (NUEVO)
   - Formulario para crear/editar ficha
   - Muestra información de la tutoría
   - Campos:
     - Problemática identificada (requerido)
     - Acciones realizadas (requerido)
     - Conclusiones (requerido)
     - Recomendaciones de seguimiento (opcional)

4. **`views/ficha/ver.php`** (NUEVO)
   - Visualización completa de la ficha
   - Información de la tutoría
   - Contenido de la ficha
   - Opción de imprimir
   - Botón de editar (solo para docente)

5. **`views/ficha/misfichas.php`** (NUEVO)
   - Lista de todas las fichas del docente
   - Estadísticas (total, últimos 30 días, este mes)
   - Acciones: Ver y Editar
   - Información de estudiante y fecha

#### Estructura de Fichas:

```php
fichas_tutoria {
    id                  // Identificador único
    tutoria_id          // ID de la tutoría
    problematica        // Descripción del problema
    acciones            // Acciones tomadas
    conclusiones        // Conclusiones de la sesión
    recomendaciones     // Seguimiento sugerido (opcional)
    fecha_registro      // Timestamp de creación
}
```

#### Validaciones:

- Solo docentes pueden crear/editar fichas
- Solo se pueden llenar fichas de tutorías "realizadas"
- Una tutoría solo puede tener una ficha
- El docente solo puede editar sus propias fichas
- Campos problemática, acciones y conclusiones son obligatorios

---

### ✅ ACTUALIZACIÓN: Dashboard Docente

**Descripción:** Dashboard completamente funcional con estadísticas en tiempo real y accesos rápidos.

#### Archivo Modificado: `views/dashboard/docente.php`

**Características implementadas:**

1. **Estadísticas en Tiempo Real:**
   - 📩 Solicitudes Pendientes
   - ✅ Tutorías Realizadas
   - 👨‍🎓 Estudiantes Atendidos (únicos)
   - 📝 Fichas Registradas

2. **Alertas Dinámicas:**
   - Alerta si hay solicitudes pendientes (con enlace directo)
   - Alerta si hay tutorías programadas para hoy

3. **Acciones Rápidas:**
   - 📩 Solicitudes (con badge si hay pendientes)
   - 📅 Mis Tutorías
   - 📝 Mis Fichas
   - 👨‍🎓 Estudiantes

4. **Tutorías de Hoy:**
   - Tabla con tutorías del día actual
   - Información: hora, estudiante, motivo, estado
   - Acceso rápido al detalle

5. **Próximas Tutorías:**
   - Lista de próximas 5 tutorías
   - Muestra: fecha, hora, estudiante, motivo, estado
   - Botón para ver todas si hay más de 5

---

## 📊 FLUJO COMPLETO DE TRABAJO

### 1. Estudiante solicita tutoría
```
Estado: pendiente
```

### 2. Docente ve solicitud en dashboard
```
Alert: "Tienes X solicitudes pendientes"
Click → Ver solicitudes
```

### 3. Docente revisa y decide
```
✅ Aprobar → estado: confirmada
❌ Rechazar → estado: cancelada
```

### 4. Tutoría confirmada
```
Aparece en:
- Dashboard → Próximas Tutorías
- Mis Tutorías
```

### 5. Día de la tutoría
```
Alert: "Tienes X tutorías programadas para hoy"
Dashboard → Tutorías de Hoy
```

### 6. Después de la sesión
```
Mis Tutorías → Ver detalle → Llenar Ficha
```

### 7. Llenar ficha de tutoría
```
Formulario con:
- Problemática identificada
- Acciones realizadas
- Conclusiones
- Recomendaciones
```

### 8. Ficha guardada
```
Visible en:
- Mis Fichas (docente)
- Historial del estudiante
- Puede ser editada posteriormente
```

---

## 🗂️ ESTRUCTURA DE ARCHIVOS

```
sistemaTutoria/
│
├── models/
│   ├── FichaTutoria.php          ← NUEVO
│   └── Tutoria.php                ← ACTUALIZADO
│
├── controllers/
│   ├── FichaController.php        ← NUEVO
│   └── TutoriaController.php      ← ACTUALIZADO
│
└── views/
    ├── dashboard/
    │   └── docente.php            ← ACTUALIZADO
    │
    ├── tutoria/
    │   ├── solicitudes_docente.php ← NUEVO
    │   └── tutorias_docente.php    ← NUEVO
    │
    └── ficha/
        ├── form.php                ← NUEVO
        ├── ver.php                 ← NUEVO
        └── misfichas.php           ← NUEVO
```

---

## 🔗 RUTAS IMPLEMENTADAS

### Solicitudes de Tutoría
- `index.php?c=tutoria&a=solicitudes` - Ver solicitudes pendientes
- `index.php?c=tutoria&a=aprobar&id={id}` - Aprobar solicitud
- `index.php?c=tutoria&a=rechazar&id={id}` - Rechazar solicitud
- `index.php?c=tutoria&a=mistutoriasdocente` - Ver todas las tutorías

### Fichas de Tutoría
- `index.php?c=ficha&a=crear&tutoria_id={id}` - Crear ficha
- `index.php?c=ficha&a=guardar` - Guardar ficha (POST)
- `index.php?c=ficha&a=ver&id={id}` - Ver ficha
- `index.php?c=ficha&a=editar&id={id}` - Editar ficha
- `index.php?c=ficha&a=actualizar` - Actualizar ficha (POST)
- `index.php?c=ficha&a=misfichas` - Ver todas las fichas

---

## 🔒 CONTROL DE ACCESO

### Restricciones:

1. **Solicitudes:**
   - Solo docentes pueden ver y gestionar solicitudes
   - Solo pueden gestionar solicitudes dirigidas a ellos

2. **Fichas:**
   - Solo docentes pueden crear/editar fichas
   - Solo pueden llenar fichas de tutorías realizadas
   - Solo pueden editar sus propias fichas
   - Una tutoría solo puede tener una ficha

3. **Visualización:**
   - Estudiantes pueden ver fichas de sus tutorías
   - Docentes pueden ver todas sus fichas
   - Admin puede ver todas las fichas

---

## 📝 VALIDACIONES IMPLEMENTADAS

### En Solicitudes:
- ✅ Verificar que el docente tenga permiso para gestionar la solicitud
- ✅ Verificar que la tutoría esté en estado "pendiente"
- ✅ Evitar aprobar/rechazar solicitudes ya procesadas

### En Fichas:
- ✅ Verificar que la tutoría exista
- ✅ Verificar que la tutoría esté en estado "realizada"
- ✅ Verificar que no exista otra ficha para esa tutoría
- ✅ Validar campos obligatorios (problemática, acciones, conclusiones)
- ✅ Verificar propiedad de la ficha al editar

---

## 🎨 ELEMENTOS DE INTERFAZ

### Badges de Estado:
```php
- pendiente    → badge-warning (amarillo)
- confirmada   → badge-info (azul)
- realizada    → badge-success (verde)
- cancelada    → badge-danger (rojo)
```

### Stat Cards:
```php
- stat-warning  → Solicitudes pendientes (naranja)
- stat-success  → Tutorías realizadas (verde)
- stat-info     → Estudiantes atendidos (azul)
- stat-primary  → Fichas registradas (morado)
```

### Alertas:
```php
- alert-warning → Solicitudes pendientes
- alert-info    → Tutorías de hoy
- alert-success → Operación exitosa
- alert-danger  → Error
```

---

## 🔄 ACTUALIZACIÓN DE BASE DE DATOS

### Script SQL: `actualizar_fichas_tutoria.sql`

**Cambio:** Agregar campo `recomendaciones` a la tabla `fichas_tutoria`

**Ejecutar:**
```sql
mysql -u root -p sistema_tutoria < actualizar_fichas_tutoria.sql
```

O desde phpMyAdmin:
1. Seleccionar base de datos `sistema_tutoria`
2. Ir a SQL
3. Copiar y pegar el contenido del archivo
4. Ejecutar

---

## ✅ CHECKLIST DE IMPLEMENTACIÓN

- [x] Modelo `Tutoria` actualizado con métodos para docentes
- [x] Controlador `TutoriaController` con gestión de solicitudes
- [x] Vistas de solicitudes y tutorías del docente
- [x] Modelo `FichaTutoria` creado
- [x] Controlador `FichaController` completo
- [x] Vistas de fichas (form, ver, listar)
- [x] Dashboard docente actualizado con estadísticas reales
- [x] Script SQL de actualización
- [x] Validaciones de seguridad implementadas
- [x] Control de acceso por roles
- [x] Mensajes de feedback al usuario

---

## 🚀 PRÓXIMAS FASES PENDIENTES

### FASE 1: Gestionar Disponibilidad Horaria
- Crear tabla `horarios_docente`
- Modelo y controlador de horarios
- Vistas para gestionar disponibilidad

### FASE 3: Registrar Seguimiento de Estudiantes
- Crear tabla `seguimientos`
- Modelo y controlador de seguimiento
- Vistas para registro de seguimiento

### FASE 5: Generar Reportes de Avance
- Controlador de reportes
- Vistas de reportes generales y por estudiante
- Exportación a PDF (opcional)

---

## 📌 NOTAS IMPORTANTES

1. **Seguridad:**
   - Todas las operaciones verifican el rol del usuario
   - Las consultas usan prepared statements (PDO)
   - Se validan permisos antes de cada operación

2. **Experiencia de Usuario:**
   - Feedback inmediato con mensajes flash
   - Navegación intuitiva con breadcrumbs
   - Estadísticas visuales en tiempo real

3. **Mantenibilidad:**
   - Código organizado siguiendo MVC
   - Funciones reutilizables
   - Comentarios claros en el código

4. **Performance:**
   - Consultas optimizadas con JOINs
   - Contadores con COUNT() en SQL
   - Limitación de resultados en vistas

---

## 📞 SOPORTE

Para dudas o problemas:
- Revisar este documento
- Consultar `PLAN_MODULO_TUTORES.md`
- Revisar código fuente con comentarios

---

**Última actualización:** 10/11/2025  
**Versión:** 1.0  
**Estado:** ✅ Fases 2 y 4 completadas

