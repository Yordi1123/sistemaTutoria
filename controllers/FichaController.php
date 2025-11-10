<?php
require_once 'controllers/AuthController.php';
require_once 'models/FichaTutoria.php';
require_once 'models/Tutoria.php';
require_once 'models/Tutor.php';

class FichaController {
    
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
    // CREAR FICHA
    // ==========================================
    
    public function crear() {
        AuthController::checkRole(['docente']);
        
        $tutoria_id = $_GET['tutoria_id'];
        
        // Verificar que la tutoría existe y está realizada
        $tutoriaModel = new Tutoria();
        $tutoria = $tutoriaModel->getById($tutoria_id);
        
        if (!$tutoria) {
            $_SESSION['error'] = 'Tutoría no encontrada';
            header('Location: index.php?c=tutoria&a=mistutoriasdocente');
            exit();
        }
        
        // Verificar que la tutoría pertenece al docente
        $docente_id = $this->getDocenteId();
        if (!$tutoriaModel->perteneceADocente($tutoria_id, $docente_id)) {
            $_SESSION['error'] = 'No tienes permiso para crear esta ficha';
            header('Location: index.php?c=tutoria&a=mistutoriasdocente');
            exit();
        }
        
        // Verificar que la tutoría está realizada
        if ($tutoria['estado'] != 'realizada') {
            $_SESSION['error'] = 'Solo puedes llenar fichas de tutorías realizadas';
            header('Location: index.php?c=tutoria&a=mistutoriasdocente');
            exit();
        }
        
        // Verificar si ya existe una ficha
        $fichaModel = new FichaTutoria();
        if ($fichaModel->existe($tutoria_id)) {
            $_SESSION['error'] = 'Esta tutoría ya tiene una ficha. Puedes editarla.';
            $ficha = $fichaModel->getByTutoria($tutoria_id);
            header('Location: index.php?c=ficha&a=editar&id=' . $ficha['id']);
            exit();
        }
        
        require_once 'views/ficha/form.php';
    }

    // Guardar ficha
    public function guardar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tutoria_id = $_POST['tutoria_id'];
            $problematica = trim($_POST['problematica']);
            $acciones = trim($_POST['acciones']);
            $conclusiones = trim($_POST['conclusiones']);
            $recomendaciones = trim($_POST['recomendaciones']);
            
            // Validaciones
            $errors = [];
            
            if (empty($problematica)) {
                $errors[] = 'La problemática es requerida';
            }
            
            if (empty($acciones)) {
                $errors[] = 'Las acciones son requeridas';
            }
            
            if (empty($conclusiones)) {
                $errors[] = 'Las conclusiones son requeridas';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=ficha&a=crear&tutoria_id=' . $tutoria_id);
                exit();
            }
            
            // Crear ficha
            $ficha = new FichaTutoria();
            $ficha->tutoria_id = $tutoria_id;
            $ficha->problematica = $problematica;
            $ficha->acciones = $acciones;
            $ficha->conclusiones = $conclusiones;
            $ficha->recomendaciones = $recomendaciones;
            
            if ($ficha->create()) {
                $_SESSION['success'] = 'Ficha de tutoría creada correctamente';
                header('Location: index.php?c=ficha&a=misfichas');
                exit();
            } else {
                $_SESSION['error'] = 'Error al crear la ficha';
                header('Location: index.php?c=ficha&a=crear&tutoria_id=' . $tutoria_id);
                exit();
            }
        }
    }

    // ==========================================
    // VER FICHA
    // ==========================================
    
    public function ver() {
        AuthController::checkAuth();
        
        $id = $_GET['id'];
        
        $fichaModel = new FichaTutoria();
        $ficha = $fichaModel->getById($id);
        
        if (!$ficha) {
            $_SESSION['error'] = 'Ficha no encontrada';
            header('Location: index.php?c=dashboard&a=' . $_SESSION['rol']);
            exit();
        }
        
        require_once 'views/ficha/ver.php';
    }

    // ==========================================
    // EDITAR FICHA
    // ==========================================
    
    public function editar() {
        AuthController::checkRole(['docente']);
        
        $id = $_GET['id'];
        
        $fichaModel = new FichaTutoria();
        $ficha = $fichaModel->getById($id);
        
        if (!$ficha) {
            $_SESSION['error'] = 'Ficha no encontrada';
            header('Location: index.php?c=ficha&a=misfichas');
            exit();
        }
        
        // Verificar que la ficha pertenece al docente
        $tutoriaModel = new Tutoria();
        $docente_id = $this->getDocenteId();
        
        if (!$tutoriaModel->perteneceADocente($ficha['tutoria_id'], $docente_id)) {
            $_SESSION['error'] = 'No tienes permiso para editar esta ficha';
            header('Location: index.php?c=ficha&a=misfichas');
            exit();
        }
        
        require_once 'views/ficha/form.php';
    }

    // Actualizar ficha
    public function actualizar() {
        AuthController::checkRole(['docente']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $problematica = trim($_POST['problematica']);
            $acciones = trim($_POST['acciones']);
            $conclusiones = trim($_POST['conclusiones']);
            $recomendaciones = trim($_POST['recomendaciones']);
            
            // Validaciones
            $errors = [];
            
            if (empty($problematica)) {
                $errors[] = 'La problemática es requerida';
            }
            
            if (empty($acciones)) {
                $errors[] = 'Las acciones son requeridas';
            }
            
            if (empty($conclusiones)) {
                $errors[] = 'Las conclusiones son requeridas';
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=ficha&a=editar&id=' . $id);
                exit();
            }
            
            // Actualizar ficha
            $ficha = new FichaTutoria();
            $ficha->id = $id;
            $ficha->problematica = $problematica;
            $ficha->acciones = $acciones;
            $ficha->conclusiones = $conclusiones;
            $ficha->recomendaciones = $recomendaciones;
            
            if ($ficha->update()) {
                $_SESSION['success'] = 'Ficha actualizada correctamente';
                header('Location: index.php?c=ficha&a=misfichas');
                exit();
            } else {
                $_SESSION['error'] = 'Error al actualizar la ficha';
                header('Location: index.php?c=ficha&a=editar&id=' . $id);
                exit();
            }
        }
    }

    // ==========================================
    // MIS FICHAS
    // ==========================================
    
    public function misfichas() {
        AuthController::checkRole(['docente']);
        
        $docente_id = $this->getDocenteId();
        
        if (!$docente_id) {
            $_SESSION['error'] = 'No se encontró perfil de docente';
            header('Location: index.php?c=dashboard&a=docente');
            exit();
        }
        
        $fichaModel = new FichaTutoria();
        $fichas = $fichaModel->getByDocente($docente_id);
        
        require_once 'views/ficha/misfichas.php';
    }
}

