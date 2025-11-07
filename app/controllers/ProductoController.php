<?php
/**
 * Controlador de Productos
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    /**
     * Lista todos los productos
     */
    public function index()
    {
        $productos = $this->productoModel->all();
        
        $data = [
            'title' => 'Productos',
            'productos' => $productos
        ];
        
        $this->render('productos/index', $data);
    }

    /**
     * Muestra el formulario para crear un producto
     */
    public function create()
    {
        $data = [
            'title' => 'Crear Producto'
        ];
        
        $this->render('productos/create', $data);
    }

    /**
     * Guarda un nuevo producto
     */
    public function store()
    {
        $data = [
            'nombre' => $this->post('nombre'),
            'precio' => $this->post('precio'),
            'descripcion' => $this->post('descripcion')
        ];

        if ($this->productoModel->create($data)) {
            $this->redirect(url('productos'));
        } else {
            echo "Error al crear el producto";
        }
    }

    /**
     * Muestra un producto específico
     */
    public function show(int $id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto) {
            $this->redirect(url('productos'));
            return;
        }

        $data = [
            'title' => 'Detalle del Producto',
            'producto' => $producto
        ];
        
        $this->render('productos/show', $data);
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function edit(int $id)
    {
        $producto = $this->productoModel->find($id);
        
        if (!$producto) {
            $this->redirect(url('productos'));
            return;
        }

        $data = [
            'title' => 'Editar Producto',
            'producto' => $producto
        ];
        
        $this->render('productos/edit', $data);
    }

    /**
     * Actualiza un producto
     */
    public function update(int $id)
    {
        $data = [
            'nombre' => $this->post('nombre'),
            'precio' => $this->post('precio'),
            'descripcion' => $this->post('descripcion')
        ];

        if ($this->productoModel->update($id, $data)) {
            $this->redirect(url('productos'));
        } else {
            echo "Error al actualizar el producto";
        }
    }

    /**
     * Elimina un producto
     */
    public function delete(int $id)
    {
        if ($this->productoModel->delete($id)) {
            $this->redirect(url('productos'));
        } else {
            echo "Error al eliminar el producto";
        }
    }
}

