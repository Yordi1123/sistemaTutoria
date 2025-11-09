<?php
require_once 'models/Tutor.php';

class TutorController {
    
    // Listar tutores
    public function index() {
        $tutorModel = new Tutor();
        $tutores = $tutorModel->getAll();
        require_once 'views/tutor/index.php';
    }

    // Mostrar formulario de crear
    public function create() {
        require_once 'views/tutor/form.php';
    }

    // Guardar tutor
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tutor = new Tutor();
            $tutor->codigo = $_POST['codigo'];
            $tutor->nombres = $_POST['nombres'];
            $tutor->apellidos = $_POST['apellidos'];
            $tutor->especialidad = $_POST['especialidad'];
            $tutor->email = $_POST['email'];
            
            if ($tutor->create()) {
                header('Location: index.php?c=tutor&a=index');
                exit();
            } else {
                echo "Error al guardar";
            }
        }
    }

    // Mostrar formulario de editar
    public function edit() {
        $id = $_GET['id'];
        $tutorModel = new Tutor();
        $tutor = $tutorModel->getById($id);
        require_once 'views/tutor/form.php';
    }

    // Actualizar tutor
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tutor = new Tutor();
            $tutor->id = $_POST['id'];
            $tutor->codigo = $_POST['codigo'];
            $tutor->nombres = $_POST['nombres'];
            $tutor->apellidos = $_POST['apellidos'];
            $tutor->especialidad = $_POST['especialidad'];
            $tutor->email = $_POST['email'];
            
            if ($tutor->update()) {
                header('Location: index.php?c=tutor&a=index');
                exit();
            } else {
                echo "Error al actualizar";
            }
        }
    }

    // Eliminar tutor
    public function delete() {
        $id = $_GET['id'];
        $tutor = new Tutor();
        if ($tutor->delete($id)) {
            header('Location: index.php?c=tutor&a=index');
            exit();
        } else {
            echo "Error al eliminar";
        }
    }
}
