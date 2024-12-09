<?php
require_once "../../config/conexion.php";
require_once "../../controllers/producto/productoController.php";
require_once "../../models/productomodels/producto.php";

$controller = new ProductoController($conexion);

// Verifica si se ha enviado el ID del producto a eliminar
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $controller->delete($id_producto); // Llama al método de eliminación
}

// Redirige a la lista de productos
header("Location: index.php");
exit();
?>