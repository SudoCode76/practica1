<?php
require_once "../../config/conexion.php";
require_once "../../controllers/producto/productoController.php";
require_once "../../models/productomodels/producto.php";

$controller = new ProductoController($conexion);

// Verifica si se ha enviado el formulario para actualizar un producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_categoria = $_POST['id_categoria'];

    // Llama al método update del controlador
    $controller->update([
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'stock' => $stock,
        'id_categoria' => $id_categoria
    ]);

    // Redirige a la lista de productos
    header("Location: index.php");
    exit();
}
?>