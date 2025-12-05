<?php
require_once 'models/Estudiante.php';

class EstudianteController {
    
    // Listar estudiantes
    public function index() {
        $estudianteModel = new Estudiante();
        $estudiantes = $estudianteModel->getAll();
        require_once 'views/estudiante/index.php';
    }

    // Mostrar formulario de crear
    public function create() {
        require_once 'views/estudiante/form.php';
    }

    // Guardar estudiante
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/Usuario.php';
            
            // 1. Crear Usuario
            $usuario = new Usuario();
            $usuario->username = $_POST['codigo']; // El código es el usuario
            $usuario->password = $_POST['codigo']; // La contraseña inicial es el código
            $usuario->rol = 'estudiante';
            
            // Verificar si el usuario ya existe
            if ($usuario->usernameExists($usuario->username)) {
                echo "El código ya está registrado como usuario";
                return;
            }
            
            if ($usuario->create()) {
                // Obtener el ID del usuario creado
                $usuarioCreado = $usuario->getByUsername($usuario->username);
                
                // 2. Crear Estudiante
                $estudiante = new Estudiante();
                $estudiante->usuario_id = $usuarioCreado['id'];
                $estudiante->codigo = $_POST['codigo'];
                $estudiante->nombres = $_POST['nombres'];
                $estudiante->apellidos = $_POST['apellidos'];
                $estudiante->email = $_POST['email'];
                $estudiante->ciclo = $_POST['ciclo'];
                $estudiante->escuela = $_POST['escuela'];
                
                if ($estudiante->create()) {
                    header('Location: index.php?c=estudiante&a=index');
                    exit();
                } else {
                    // Si falla crear estudiante, deberíamos borrar el usuario (rollback manual)
                    $usuario->delete($usuarioCreado['id']);
                    echo "Error al guardar estudiante";
                }
            } else {
                echo "Error al crear usuario";
            }
        }
    }

    // Mostrar formulario de editar
    public function edit() {
        $id = $_GET['id'];
        $estudianteModel = new Estudiante();
        $estudiante = $estudianteModel->getById($id);
        require_once 'views/estudiante/form.php';
    }

    // Actualizar estudiante
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $estudiante = new Estudiante();
            $estudiante->id = $_POST['id'];
            $estudiante->codigo = $_POST['codigo'];
            $estudiante->nombres = $_POST['nombres'];
            $estudiante->apellidos = $_POST['apellidos'];
            $estudiante->email = $_POST['email'];
            $estudiante->ciclo = $_POST['ciclo'];
            $estudiante->escuela = $_POST['escuela'];
            
            if ($estudiante->update()) {
                header('Location: index.php?c=estudiante&a=index');
                exit();
            } else {
                echo "Error al actualizar";
            }
        }
    }

    // Eliminar estudiante
    public function delete() {
        $id = $_GET['id'];
        $estudiante = new Estudiante();
        if ($estudiante->delete($id)) {
            header('Location: index.php?c=estudiante&a=index');
            exit();
        } else {
            echo "Error al eliminar";
        }
    }
}
