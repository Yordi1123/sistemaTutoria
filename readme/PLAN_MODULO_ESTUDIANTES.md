# 📋 Plan de Implementación - Módulo de Estudiantes

## 🎯 Objetivo
Implementar funcionalidades completas para que los estudiantes puedan gestionar sus tutorías de manera eficiente.

## 📊 Funcionalidades a Implementar

### 1. ✅ Solicitar Sesiones de Tutoría
### 2. ✅ Visualizar Horarios Disponibles de Tutores
### 3. ✅ Registrar Asistencia a Sesiones
### 4. ✅ Consultar Historial de Tutorías
### 5. ✅ Recibir Notificaciones

---

## 🗂️ Análisis de Base de Datos Existente

### Tablas Disponibles:
```sql
✅ usuarios          - Usuarios del sistema
✅ estudiantes       - Datos de estudiantes
✅ docentes          - Datos de docentes/tutores
✅ tutorias          - Registro de tutorías
   - id
   - estudiante_id
   - docente_id
   - fecha
   - hora
   - motivo
   - estado (pendiente, confirmada, realizada, cancelada)
   - observaciones
   - fecha_registro

✅ fichas_tutoria    - Detalles de sesiones realizadas
```

---

## 📝 Plan de Implementación Detallado

### **FASE 1: Visualizar Horarios y Tutores Disponibles** 🕐
*Prioridad: Alta | Tiempo estimado: 30 min*

#### Archivos a crear/modificar:
1. **Modelo: `models/Horario.php`**
   - Gestionar horarios de disponibilidad de tutores
   - Método: `getHorariosDisponibles($tutor_id, $fecha)`
   - Método: `verificarDisponibilidad($tutor_id, $fecha, $hora)`

2. **Vista: `views/estudiante/tutores_disponibles.php`**
   - Listar todos los tutores
   - Mostrar especialidades
   - Botón "Ver Horarios" por cada tutor
   - Filtros: por especialidad, por nombre

3. **Vista: `views/estudiante/horarios_tutor.php`**
   - Calendario/lista de horarios disponibles
   - Información del tutor seleccionado
   - Botón "Solicitar Tutoría" en cada horario

#### Flujo:
```
Estudiante → Ver Tutores → Seleccionar Tutor → Ver Horarios → Solicitar
```

---

### **FASE 2: Solicitar Sesiones de Tutoría** 📝
*Prioridad: Alta | Tiempo estimado: 45 min*

#### Archivos a crear/modificar:
1. **Modelo: `models/Tutoria.php`**
   - `create()` - Crear nueva solicitud
   - `getByEstudiante($estudiante_id)` - Tutorías del estudiante
   - `getByDocente($docente_id)` - Tutorías del docente
   - `updateEstado($id, $estado)` - Cambiar estado
   - `verificarConflictos($docente_id, $fecha, $hora)` - Evitar dobles citas

2. **Controlador: `controllers/TutoriaController.php`**
   - `solicitar()` - Mostrar formulario
   - `store()` - Guardar solicitud
   - `misolicitudes()` - Ver solicitudes del estudiante
   - `cancelar($id)` - Cancelar solicitud

3. **Vista: `views/tutoria/solicitar.php`**
   - Formulario de solicitud
   - Seleccionar tutor (dropdown)
   - Seleccionar fecha y hora
   - Campo motivo/tema
   - Validación de campos

4. **Actualizar: `controllers/EstudianteController.php`**
   - Integrar con perfil de estudiante de la BD

#### Validaciones:
- ✅ Estudiante debe existir en la tabla `estudiantes`
- ✅ Tutor debe estar disponible
- ✅ No puede haber conflicto de horarios
- ✅ Fecha debe ser futura
- ✅ Horario debe estar en rango válido (8am - 6pm)

---

### **FASE 3: Consultar Historial de Tutorías** 📚
*Prioridad: Media | Tiempo estimado: 30 min*

#### Archivos a crear/modificar:
1. **Vista: `views/tutoria/historial.php`**
   - Tabla con todas las tutorías del estudiante
   - Filtros: por estado, por fecha, por tutor
   - Columnas:
     - Fecha y hora
     - Tutor
     - Motivo
     - Estado (badge con color)
     - Acciones (ver detalle, cancelar)
   - Paginación

2. **Actualizar: `models/Tutoria.php`**
   - `getHistorialEstudiante($estudiante_id, $filters)`
   - `getDetalle($id)` - Detalle completo
   - `getEstadisticas($estudiante_id)` - Stats

3. **Vista: `views/tutoria/detalle.php`**
   - Información completa de la tutoría
   - Datos del tutor
   - Fecha y hora
   - Motivo
   - Observaciones (si las hay)
   - Ficha de tutoría (si fue realizada)

#### Estadísticas a mostrar:
- Total de tutorías solicitadas
- Tutorías completadas
- Tutorías pendientes
- Tutorías canceladas

---

### **FASE 4: Registrar Asistencia a Sesiones** ✅
*Prioridad: Media-Alta | Tiempo estimado: 40 min*

#### Archivos a crear/modificar:
1. **Vista: `views/tutoria/confirmar_asistencia.php`**
   - Lista de tutorías confirmadas próximas
   - Botón "Confirmar Asistencia"
   - Solo visible el día de la tutoría
   - Código QR o PIN de confirmación (opcional)

2. **Actualizar: `models/Tutoria.php`**
   - `confirmarAsistencia($id, $estudiante_id)`
   - Agregar campo `asistencia_confirmada` (boolean)
   - `getTutoriasDelDia($estudiante_id, $fecha)`

3. **Actualizar: `controllers/TutoriaController.php`**
   - `confirmarAsistencia()` - Registrar asistencia
   - `tutoriasHoy()` - Ver tutorías del día

#### Lógica:
```
Si la tutoría está "confirmada" Y es el día de la sesión
  → Estudiante puede confirmar asistencia
  → Al confirmar: estado = "realizada"
  → Tutor puede llenar ficha
```

---

### **FASE 5: Recibir Notificaciones** 🔔
*Prioridad: Baja | Tiempo estimado: 60 min*

#### Archivos a crear/modificar:
1. **Modelo: `models/Notificacion.php`**
   - `create($usuario_id, $tipo, $mensaje)` - Crear notificación
   - `getByUsuario($usuario_id)` - Obtener notificaciones
   - `marcarLeida($id)` - Marcar como leída
   - `getNuevas($usuario_id)` - Solo no leídas
   - `limpiarAntiguas($dias)` - Limpieza automática

2. **Tabla BD: `notificaciones`**
   ```sql
   CREATE TABLE notificaciones (
       id INT AUTO_INCREMENT PRIMARY KEY,
       usuario_id INT NOT NULL,
       tipo ENUM('tutoria_confirmada', 'tutoria_cancelada', 
                 'recordatorio', 'general') NOT NULL,
       mensaje TEXT NOT NULL,
       leida BOOLEAN DEFAULT FALSE,
       fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
   );
   ```

3. **Componente: `views/layout/notificaciones.php`**
   - Icono de campana en header
   - Badge con cantidad de no leídas
   - Dropdown con lista de notificaciones
   - AJAX para actualizar en tiempo real (opcional)

4. **Sistema de Notificaciones:**
   - Al crear tutoría → Notificar a tutor
   - Al confirmar tutoría → Notificar a estudiante
   - Al cancelar → Notificar a ambos
   - 1 día antes → Recordatorio automático

---

## 🏗️ Estructura de Archivos (Nuevos)

```
sistemaTutoria/
│
├── controllers/
│   ├── TutoriaController.php     ✨ NUEVO
│   └── NotificacionController.php ✨ NUEVO (Fase 5)
│
├── models/
│   ├── Tutoria.php                ✨ NUEVO
│   ├── Horario.php                ✨ NUEVO (Fase 1)
│   └── Notificacion.php           ✨ NUEVO (Fase 5)
│
├── views/
│   ├── tutoria/                   ✨ NUEVA CARPETA
│   │   ├── solicitar.php
│   │   ├── historial.php
│   │   ├── detalle.php
│   │   └── confirmar_asistencia.php
│   │
│   ├── estudiante/
│   │   ├── tutores_disponibles.php ✨ NUEVO
│   │   └── horarios_tutor.php      ✨ NUEVO
│   │
│   └── layout/
│       └── notificaciones.php      ✨ NUEVO (Fase 5)
│
└── assets/
    ├── css/
    │   └── style.css              📝 Agregar estilos
    └── js/
        ├── main.js                📝 Actualizar
        └── notificaciones.js      ✨ NUEVO (Fase 5)
```

---

## 🎨 Mejoras de UI/UX

### Dashboard Estudiante (Actualizar)
- ✅ Widget "Próximas Tutorías"
- ✅ Estadísticas visuales
- ✅ Botón grande "Solicitar Tutoría"
- ✅ Alertas de tutorías del día

### Calendario Visual (Opcional)
- Integrar vista de calendario
- Marcar días con tutorías
- Visualizar disponibilidad

---

## 📊 Flujos de Usuario

### 🔄 Flujo 1: Solicitar Tutoría
```
1. Estudiante → Dashboard
2. Click "Solicitar Tutoría"
3. Ver lista de tutores disponibles
4. Seleccionar tutor
5. Ver horarios disponibles
6. Seleccionar fecha/hora
7. Escribir motivo
8. Confirmar solicitud
9. Estado: "pendiente"
10. Notificación al tutor
```

### 🔄 Flujo 2: Confirmar Asistencia
```
1. Sistema verifica tutorías del día
2. Estudiante recibe notificación/recordatorio
3. Estudiante → "Mis Tutorías"
4. Ve tutorías de hoy
5. Click "Confirmar Asistencia"
6. Estado cambia a "realizada"
7. Tutor puede llenar ficha
```

### 🔄 Flujo 3: Ver Historial
```
1. Estudiante → Dashboard
2. Click "Mi Historial"
3. Ver todas las tutorías
4. Filtrar por estado/fecha
5. Click en tutoría → Ver detalle
6. Ver ficha si existe
```

---

## ✅ Checklist de Implementación

### Fase 1: Horarios y Tutores ⏰
- [ ] Crear modelo Horario.php
- [ ] Vista tutores_disponibles.php
- [ ] Vista horarios_tutor.php
- [ ] Estilos CSS para cards de tutores
- [ ] Integrar en dashboard estudiante

### Fase 2: Solicitar Tutorías 📝
- [ ] Crear modelo Tutoria.php
- [ ] Crear TutoriaController.php
- [ ] Vista solicitar.php (formulario)
- [ ] Validaciones backend
- [ ] Verificación de conflictos
- [ ] Mensajes de confirmación

### Fase 3: Historial 📚
- [ ] Vista historial.php
- [ ] Vista detalle.php
- [ ] Métodos en modelo Tutoria
- [ ] Filtros y búsqueda
- [ ] Paginación
- [ ] Estadísticas

### Fase 4: Asistencia ✅
- [ ] Vista confirmar_asistencia.php
- [ ] Método confirmarAsistencia()
- [ ] Lógica de validación de fecha
- [ ] Actualización de estado
- [ ] Widget en dashboard

### Fase 5: Notificaciones 🔔
- [ ] Crear tabla notificaciones
- [ ] Modelo Notificacion.php
- [ ] NotificacionController.php
- [ ] Componente visual en header
- [ ] Sistema de triggers
- [ ] AJAX para actualización (opcional)

---

## 🔧 Consideraciones Técnicas

### Base de Datos
- Tabla `tutorias` ya existe ✅
- Agregar campo `asistencia_confirmada` BOOLEAN
- Crear tabla `notificaciones` (Fase 5)
- Índices en campos de búsqueda frecuente

### Seguridad
- ✅ Verificar que el estudiante solo vea sus propias tutorías
- ✅ Validar permisos en cada acción
- ✅ Prevenir SQL injection (ya implementado con PDO)
- ✅ Validar fechas y horarios

### Performance
- Caché de horarios disponibles
- Límite de solicitudes por estudiante
- Paginación en listados
- Índices en BD

---

## 📅 Cronograma Estimado

| Fase | Funcionalidad | Tiempo | Prioridad |
|------|--------------|--------|-----------|
| **1** | Visualizar Horarios | 30 min | Alta |
| **2** | Solicitar Tutorías | 45 min | Alta |
| **3** | Historial | 30 min | Media |
| **4** | Asistencia | 40 min | Media-Alta |
| **5** | Notificaciones | 60 min | Baja |
| | **TOTAL** | **3h 25min** | |

---

## 🚀 Orden de Implementación Recomendado

### Sesión 1 (1 hora)
1. ✅ Fase 1: Visualizar tutores y horarios
2. ✅ Actualizar dashboard estudiante

### Sesión 2 (1 hora)
1. ✅ Fase 2: Solicitar tutorías (parte 1)
2. ✅ Modelo + Controlador + Formulario

### Sesión 3 (45 min)
1. ✅ Fase 2: Solicitar tutorías (parte 2)
2. ✅ Validaciones + Testing
3. ✅ Fase 3: Historial básico

### Sesión 4 (45 min)
1. ✅ Fase 4: Asistencia
2. ✅ Mejoras UI/UX

### Sesión 5 (Opcional - 1 hora)
1. ✅ Fase 5: Sistema de notificaciones

---

## 🎯 Resultado Final Esperado

### Para el Estudiante:
✅ Dashboard con información relevante
✅ Puede ver todos los tutores y sus especialidades
✅ Puede ver horarios disponibles de cada tutor
✅ Puede solicitar tutorías fácilmente
✅ Recibe notificaciones de estado
✅ Puede confirmar su asistencia
✅ Puede ver su historial completo
✅ Tiene estadísticas de sus tutorías

### Para el Tutor (Beneficio Adicional):
✅ Recibe notificaciones de nuevas solicitudes
✅ Puede gestionar sus tutorías
✅ Puede ver quién confirmó asistencia

### Para el Admin:
✅ Puede ver todas las tutorías del sistema
✅ Tiene acceso a reportes
✅ Puede supervisar el proceso

---

## 📝 Notas Adicionales

- Mantener estructura simple sin carpetas innecesarias ✅
- Seguir patrón MVC establecido ✅
- Reutilizar componentes existentes ✅
- Mobile responsive ✅
- Sin librerías externas (PHP, HTML, CSS, JS puros) ✅

---

## 🎉 ¿Listo para Empezar?

**Pregunta:** ¿Con qué fase quieres empezar?

**Recomendación:** Empezar por Fase 1 y 2 (Visualizar tutores y Solicitar tutorías) ya que son la base del sistema.

Una vez aprobado el plan, empezamos la implementación paso a paso. 🚀

