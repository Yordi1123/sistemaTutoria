<?php
class HomeController {
    
    public function index() {
        // Si el usuario ya está logueado, redirigir a su dashboard
        if (isset($_SESSION['user_id'])) {
            $rol = $_SESSION['rol'];
            switch ($rol) {
                case 'coordinador':
                    header('Location: index.php?c=dashboard&a=admin');
                    exit();
                case 'docente':
                    header('Location: index.php?c=dashboard&a=docente');
                    exit();
                case 'estudiante':
                    header('Location: index.php?c=dashboard&a=estudiante');
                    exit();
            }
        }
        
        // Mostrar landing page
        require_once 'views/home/landing.php';
    }
    
    // Vista antigua para cuando estén logueados
    public function dashboard() {
        require_once 'views/home/index.php';
    }
}

