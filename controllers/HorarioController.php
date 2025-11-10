<?php
require_once 'controllers/AuthController.php';
require_once 'models/HorarioDocente.php';
require_once 'models/Tutor.php';

class HorarioController {
    
    // Obtener docente_id del usuario logueado
    private function getDocenteId() {
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        foreach ($tutores as $tutor) {
            if ($tutor['usuario_id'] == $_SESSION['user_id']) {
                return $tutor['id'];
            }
        }
        
        return null;
    }

    // ==========================================
    // LISTAR HORARIOS
    // ==========================================
    
    public function index() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        $horarioModel = new HorarioDocente();
        $horarios = $horarioModel->getByDocente($docente_id);
        $horariosAgrupados = $horarioModel->getHorariosAgrupados($docente_id);
        
        require_once 'views/horario/index.php';
    }

    // ==========================================
    // CREAR HORARIO
    // ==========================================
    
    public function crear() {
        AuthController::checkRole(['docente']);
        
        require_once 'views/horario/form.php';
    }

    // Guardar horario
    public function guardar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $docente_id = $this->getDocenteId();
            $dia_semana = $_POST['dia_semana'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fin = $_POST['hora_fin'];
            $estado = isset($_POST['estado']) ? $_POST['estado'] : 'activo';
            
            // Validaciones
            $errors = [];
            
            if (empty($dia_semana)) {
                $errors[] = 'El día de la semana es requerido';
            }
            
            if (empty($hora_inicio)) {
                $errors[] = 'La hora de inicio es requerida';
            }
            
            if (empty($hora_fin)) {
                $errors[] = 'La hora de fin es requerida';
            }
            
            // Validar que hora_fin sea mayor que hora_inicio
            if (!empty($hora_inicio) && !empty($hora_fin)) {
                if (strtotime($hora_fin) <= strtotime($hora_inicio)) {
                    $errors[] = 'La hora de fin debe ser mayor que la hora de inicio';
                }
            }
            
            // Verificar conflictos de horario
            if (empty($errors)) {
                $horarioModel = new HorarioDocente();
                if ($horarioModel->existeConflicto($docente_id, $dia_semana, $hora_inicio, $hora_fin)) {
                    $errors[] = 'Ya existe un horario que se solapa con el horario ingresado';
                }
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=horario&a=crear');
                exit();
            }
            
            // Crear horario
            $horario = new HorarioDocente();
            $horario->docente_id = $docente_id;
            $horario->dia_semana = $dia_semana;
            $horario->hora_inicio = $hora_inicio;
            $horario->hora_fin = $hora_fin;
            $horario->estado = $estado;
            
            if ($horario->create()) {
                $_SESSION['success'] = 'Horario creado correctamente';
                header('Location: index.php?c=horario&a=index');
                exit();
            } else {
                $_SESSION['error'] = 'Error al crear el horario';
                header('Location: index.php?c=horario&a=crear');
                exit();
            }
        }
    }

    // ==========================================
    // EDITAR HORARIO
    // ==========================================
    
    public function editar() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        
        $horarioModel = new HorarioDocente();
        $horario = $horarioModel->getById($id);
        
        if (!$horario) {
            $_SESSION['error'] = 'Horario no encontrado';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        // Verificar que el horario pertenece al docente logueado
        $docente_id = $this->getDocenteId();
        if ($horario['docente_id'] != $docente_id) {
            $_SESSION['error'] = 'No tienes permiso para editar este horario';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        require_once 'views/horario/form.php';
    }

    // Actualizar horario
    public function actualizar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $dia_semana = $_POST['dia_semana'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fin = $_POST['hora_fin'];
            $estado = isset($_POST['estado']) ? $_POST['estado'] : 'activo';
            
            $docente_id = $this->getDocenteId();
            
            // Validaciones
            $errors = [];
            
            if (empty($dia_semana)) {
                $errors[] = 'El día de la semana es requerido';
            }
            
            if (empty($hora_inicio)) {
                $errors[] = 'La hora de inicio es requerida';
            }
            
            if (empty($hora_fin)) {
                $errors[] = 'La hora de fin es requerida';
            }
            
            // Validar que hora_fin sea mayor que hora_inicio
            if (!empty($hora_inicio) && !empty($hora_fin)) {
                if (strtotime($hora_fin) <= strtotime($hora_inicio)) {
                    $errors[] = 'La hora de fin debe ser mayor que la hora de inicio';
                }
            }
            
            // Verificar conflictos de horario (excluyendo el horario actual)
            if (empty($errors)) {
                $horarioModel = new HorarioDocente();
                if ($horarioModel->existeConflicto($docente_id, $dia_semana, $hora_inicio, $hora_fin, $id)) {
                    $errors[] = 'Ya existe un horario que se solapa con el horario ingresado';
                }
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=horario&a=editar&id=' . $id);
                exit();
            }
            
            // Actualizar horario
            $horario = new HorarioDocente();
            $horario->id = $id;
            $horario->dia_semana = $dia_semana;
            $horario->hora_inicio = $hora_inicio;
            $horario->hora_fin = $hora_fin;
            $horario->estado = $estado;
            
            if ($horario->update()) {
                $_SESSION['success'] = 'Horario actualizado correctamente';
                header('Location: index.php?c=horario&a=index');
                exit();
            } else {
                $_SESSION['error'] = 'Error al actualizar el horario';
                header('Location: index.php?c=horario&a=editar&id=' . $id);
                exit();
            }
        }
    }

    // ==========================================
    // CAMBIAR ESTADO
    // ==========================================
    
    public function cambiarEstado() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        $estado = $_GET['estado'];
        
        // Verificar que el horario pertenece al docente
        $horarioModel = new HorarioDocente();
        $horario = $horarioModel->getById($id);
        
        if (!$horario) {
            $_SESSION['error'] = 'Horario no encontrado';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        $docente_id = $this->getDocenteId();
        if ($horario['docente_id'] != $docente_id) {
            $_SESSION['error'] = 'No tienes permiso para modificar este horario';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        if ($horarioModel->cambiarEstado($id, $estado)) {
            $_SESSION['success'] = 'Estado del horario actualizado';
        } else {
            $_SESSION['error'] = 'Error al actualizar el estado';
        }
        
        header('Location: index.php?c=horario&a=index');
        exit();
    }

    // ==========================================
    // ELIMINAR HORARIO
    // ==========================================
    
    public function eliminar() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        
        // Verificar que el horario pertenece al docente
        $horarioModel = new HorarioDocente();
        $horario = $horarioModel->getById($id);
        
        if (!$horario) {
            $_SESSION['error'] = 'Horario no encontrado';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        $docente_id = $this->getDocenteId();
        if ($horario['docente_id'] != $docente_id) {
            $_SESSION['error'] = 'No tienes permiso para eliminar este horario';
            header('Location: index.php?c=horario&a=index');
            exit();
        }
        
        if ($horarioModel->delete($id)) {
            $_SESSION['success'] = 'Horario eliminado correctamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el horario';
        }
        
        header('Location: index.php?c=horario&a=index');
        exit();
    }
}

