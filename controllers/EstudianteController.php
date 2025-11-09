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
            $estudiante = new Estudiante();
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
                echo "Error al guardar";
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
