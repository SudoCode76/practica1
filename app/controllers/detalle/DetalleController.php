<?php

require_once "../config/conexion.php";  // Asegúrate de que esta ruta es correcta
//require_once "../models/Detalle.php";
require_once "../models/detallesmodels/Detalle.php";

class DetalleController
{
    private $detalleModel;

    public function __construct()
    {
        global $conexion; // Utilizamos la conexión desde conexion.php
        $this->detalleModel = new Detalle($conexion);
    }

    // Muestra todos los detalles
    public function index()
    {
        $detalles = $this->detalleModel->getAllDetalles();
        include "../views/detalle/index.php";
    }

    // Muestra los detalles de un detalle específico
    public function show($id_factura, $num_detalle)
    {
        $detalle = $this->detalleModel->getDetalleById($id_factura, $num_detalle);
        include "../views/detalle/show.php";  // Asegúrate de que la ruta es correcta
    }

    // Muestra el formulario de creación
    public function create()
    {
        include "../views/detalle/create.php";  // Asegúrate de que la ruta es correcta
    }

    // Guarda un nuevo detalle
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_factura = $_POST['id_factura'];
            $num_detalle = $_POST['num_detalle'];
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];

            $this->detalleModel->createDetalle($id_factura, $num_detalle, $id_producto, $cantidad, $precio);
            header("Location: ../views/detalle/index.php");  // Redirige a la vista de detalles
        }
    }

    // Muestra el formulario de edición para un detalle
    public function edit($id_factura, $num_detalle)
    {
        $detalle = $this->detalleModel->getDetalleById($id_factura, $num_detalle);
        include "../views/detalle/edit.php";  // Asegúrate de que la ruta es correcta
    }

    // Actualiza un detalle existente
    public function update($id_factura, $num_detalle)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_producto = $_POST['id_producto'];
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];

            $this->detalleModel->updateDetalle($id_factura, $num_detalle, $id_producto, $cantidad, $precio);
            header("Location: ../views/detalle/index.php");  // Redirige a la vista de detalles
        }
    }

    // Elimina un detalle
    public function delete($id_factura, $num_detalle)
    {
        $this->detalleModel->deleteDetalle($id_factura, $num_detalle);
        header("Location: ../views/detalle/index.php");  // Redirige a la vista de detalles
    }
}

$controller = new DetalleController();
$action = $_GET['action'] ?? 'index';
$id_factura = $_GET['id_factura'] ?? null;
$num_detalle = $_GET['num_detalle'] ?? null;

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'show':
        $controller->show($id_factura, $num_detalle);
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($id_factura, $num_detalle);
        break;
    case 'update':
        $controller->update($id_factura, $num_detalle);
        break;
    case 'delete':
        $controller->delete($id_factura, $num_detalle);
        break;
    default:
        $controller->index();
        break;
}
