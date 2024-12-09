<?php

require_once "../config/conexion.php";  // Asegúrate de que esta ruta es correcta
//require_once "../models/Categoria.php";
require_once "../models/categoriamodels/Categoria.php";

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        global $conexion; // Utilizamos la conexión desde conexion.php
        $this->categoriaModel = new Categoria($conexion);
    }

    // Muestra todas las categorías

    public function index()
    {
        $categorias = $this->categoriaModel->getAllCategorias();
        include "../views/categoria/index.php";
    }

    // Muestra los detalles de una categoría
    public function show($id)
    {
        $categoria = $this->categoriaModel->getCategoriaById($id);
        include "../views/categoria/show.php";  // Asegúrate de que la ruta es correcta
    }

    // Muestra el formulario de creación
    public function create()
    {
        include "../views/categoria/create.php";  // Asegúrate de que la ruta es correcta
    }

    // Guarda una nueva categoría
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            $this->categoriaModel->createCategoria($nombre, $descripcion);
            header("Location: ../views/categoria/index.php");  // Redirige a la vista de categorías
        }
    }

    // Muestra el formulario de edición para una categoría
    public function edit($id)
    {
        $categoria = $this->categoriaModel->getCategoriaById($id);
        include "../views/categoria/edit.php";  // Asegúrate de que la ruta es correcta
    }

    // Actualiza una categoría existente
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            $this->categoriaModel->updateCategoria($id, $nombre, $descripcion);
            header("Location: ../views/categoria/index.php");  // Redirige a la vista de categorías
        }
    }

    // Elimina una categoría
    public function delete($id)
    {
        $this->categoriaModel->deleteCategoria($id);
        header("Location: ../views/categoria/index.php");  // Redirige a la vista de categorías
    }
}

$controller = new CategoriaController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'show':
        $controller->show($id);
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
