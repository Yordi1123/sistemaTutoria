<?php
/**
 * Controlador de Usuarios
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    /**
     * Lista todos los usuarios
     */
    public function index()
    {
        $usuarios = $this->usuarioModel->all();
        
        $data = [
            'title' => 'Usuarios',
            'usuarios' => $usuarios
        ];
        
        $this->render('usuarios/index', $data);
    }

    /**
     * Muestra el formulario para crear un usuario
     */
    public function create()
    {
        $data = [
            'title' => 'Crear Usuario'
        ];
        
        $this->render('usuarios/create', $data);
    }

    /**
     * Guarda un nuevo usuario
     */
    public function store()
    {
        $data = [
            'nombre' => $this->post('nombre'),
            'email' => $this->post('email'),
            'password' => password_hash($this->post('password'), PASSWORD_DEFAULT)
        ];

        if ($this->usuarioModel->create($data)) {
            $this->redirect(url('usuarios'));
        } else {
            echo "Error al crear el usuario";
        }
    }

    /**
     * Muestra un usuario específico
     */
    public function show(int $id)
    {
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            $this->redirect(url('usuarios'));
            return;
        }

        $data = [
            'title' => 'Detalle del Usuario',
            'usuario' => $usuario
        ];
        
        $this->render('usuarios/show', $data);
    }

    /**
     * Muestra el formulario para editar un usuario
     */
    public function edit(int $id)
    {
        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            $this->redirect(url('usuarios'));
            return;
        }

        $data = [
            'title' => 'Editar Usuario',
            'usuario' => $usuario
        ];
        
        $this->render('usuarios/edit', $data);
    }

    /**
     * Actualiza un usuario
     */
    public function update(int $id)
    {
        $data = [
            'nombre' => $this->post('nombre'),
            'email' => $this->post('email')
        ];

        // Si se proporciona una nueva contraseña, actualizarla
        if (!empty($this->post('password'))) {
            $data['password'] = password_hash($this->post('password'), PASSWORD_DEFAULT);
        }

        if ($this->usuarioModel->update($id, $data)) {
            $this->redirect(url('usuarios'));
        } else {
            echo "Error al actualizar el usuario";
        }
    }

    /**
     * Elimina un usuario
     */
    public function delete(int $id)
    {
        if ($this->usuarioModel->delete($id)) {
            $this->redirect(url('usuarios'));
        } else {
            echo "Error al eliminar el usuario";
        }
    }
}

