<?php
require_once "../../config/conexion.php";
require_once "../../controllers/producto/productoController.php";
require_once "../../models/productomodels/producto.php";

$controller = new ProductoController($conexion);

// Obtiene el ID del producto a editar
$id = $_GET['id'];

// Obtiene la lista de productos
$productos = $controller->read();

// Filtra el producto por ID
$producto = array_filter($productos, fn($p) => $p['id_producto'] == $id);
$producto = array_shift($producto); // Obtiene el primer (y único) elemento del array

// Verifica si se encontró el producto
if (!$producto) {
    die("Producto no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="guardar_cambios.php" method="POST">
            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>"> <!-- Asegúrate de enviar el ID del producto -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_categoria">ID Categoría:</label>
                <input type="number" id="id_categoria" name="id_categoria" value="<?php echo htmlspecialchars($producto['id_categoria']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Producto</button>
            </div>
        </form>
    </div>
</body>

</html>