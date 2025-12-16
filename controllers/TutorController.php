<?php
require_once 'models/Tutor.php';
require_once 'controllers/AuthController.php';

class TutorController {
    
    // Listar tutores - Coordinador ve CRUD completo, estudiante ve solo lectura
    public function index() {
        AuthController::checkAuth();
        
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        
        // Si es estudiante, mostrar vista de solo lectura
        if ($_SESSION['rol'] == 'estudiante') {
            require_once 'views/tutor/list_readonly.php';
        } else {
            require_once 'views/tutor/index.php';
        }
    }

    // Mostrar formulario de crear - Solo coordinador
    public function create() {
        AuthController::checkRole(['coordinador']);
        
        require_once 'views/tutor/form.php';
    }

    // Guardar tutor - Solo coordinador
    public function save() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];
            
            // Obtener y limpiar datos
            $codigo = trim($_POST['codigo'] ?? '');
            $nombres = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $especialidad = trim($_POST['especialidad'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            // Validar campos obligatorios
            if (empty($codigo)) $errors[] = 'El código es obligatorio';
            if (empty($nombres)) $errors[] = 'Los nombres son obligatorios';
            if (empty($apellidos)) $errors[] = 'Los apellidos son obligatorios';
            if (empty($especialidad)) $errors[] = 'La especialidad es obligatoria';
            if (empty($email)) $errors[] = 'El email es obligatorio';
            
            // Validar formato de email
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El formato del email no es válido';
            }
            
            // Si hay errores, volver al formulario
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=tutor&a=create');
                exit();
            }
            
            $tutor = new Tutor();
            $tutor->codigo = $codigo;
            $tutor->nombres = $nombres;
            $tutor->apellidos = $apellidos;
            $tutor->especialidad = $especialidad;
            $tutor->email = $email;
            
            if ($tutor->create()) {
                $_SESSION['success'] = 'Tutor registrado correctamente';
                header('Location: index.php?c=tutor&a=index');
                exit();
            } else {
                $_SESSION['error'] = 'Error al guardar tutor';
                $_SESSION['old'] = $_POST;
                header('Location: index.php?c=tutor&a=create');
                exit();
            }
        }
    }

    // Mostrar formulario de editar - Solo coordinador
    public function edit() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        $tutorModel = new Tutor();
        $tutor = $tutorModel->getById($id);
        require_once 'views/tutor/form.php';
    }

    // Actualizar tutor - Solo coordinador
    public function update() {
        AuthController::checkRole(['coordinador']);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tutor = new Tutor();
            $tutor->id = $_POST['id'];
            $tutor->codigo = $_POST['codigo'];
            $tutor->nombres = $_POST['nombres'];
            $tutor->apellidos = $_POST['apellidos'];
            $tutor->especialidad = $_POST['especialidad'];
            $tutor->email = $_POST['email'];
            
            if ($tutor->update()) {
                $_SESSION['success'] = 'Tutor actualizado correctamente';
                header('Location: index.php?c=tutor&a=index');
                exit();
            } else {
                $_SESSION['error'] = 'Error al actualizar';
                header('Location: index.php?c=tutor&a=edit&id=' . $_POST['id']);
                exit();
            }
        }
    }

    // Eliminar tutor - Solo coordinador
    public function delete() {
        AuthController::checkRole(['coordinador']);
        
        $id = $_GET['id'];
        $tutor = new Tutor();
        if ($tutor->delete($id)) {
            $_SESSION['success'] = 'Tutor eliminado correctamente';
            header('Location: index.php?c=tutor&a=index');
            exit();
        } else {
            $_SESSION['error'] = 'Error al eliminar';
            header('Location: index.php?c=tutor&a=index');
            exit();
        }
    }
}
