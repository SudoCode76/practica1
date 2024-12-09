<?php

require_once '../../models/facturamodels/Factura.php';
//require_once 'models/Factura.php';

require_once '../../controllers/factura/FacturaController.php';
//require_once 'controllers/FacturaController.php';
//require_once '../config/conexion.php'; // Asegúrate de que la ruta sea correcta
require_once '../../config/conexion.php';

$facturaController = new FacturaController($conexion);

// Manejar la creación de una nueva factura
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $id_cliente = $_POST['id_cliente'];
    $num_pago = $_POST['num_pago'];
    $facturaController->crear($fecha, $id_cliente, $num_pago);
}

// Obtener la lista de facturas
$facturas = $facturaController->listar();

?>

<?php include("../template/cabecera.php"); ?>

<div class="flex-1 p-6">
    <h1 class="text-2xl font-bold mb-4">Listado de Facturas</h1>
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">Número de Factura</th>
                <th class="py-2 px-4 border">Fecha</th>
                <th class="py-2 px-4 border">Nombre del Cliente</th>
                <th class="py-2 px-4 border">Número de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturas as $factura): ?>
                <tr>
                    <td class="py-2 px-4 border"><?php echo $factura['num_factura']; ?></td>
                    <td class="py-2 px-4 border"><?php echo $factura['fecha']; ?></td>
                    <td class="py-2 px-4 border"><?php echo $factura['nombre_cliente']; ?></td> <!-- Nombre del cliente aquí -->
                    <td class="py-2 px-4 border"><?php echo $factura['num_pago']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="text-xl font-bold mt-6">Crear Factura</h2>
    <form method="POST" action="" class="mt-4">
        <div class="mb-4">
            <label for="fecha" class="block text-gray-700">Fecha:</label>
            <input type="date" name="fecha" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div class="mb-4">
            <label for="id_cliente" class="block text-gray-700">ID Cliente:</label>
            <input type="number" name="id_cliente" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <div class="mb-4">
            <label for="num_pago" class="block text-gray-700">Número de Pago:</label>
            <input type="number" name="num_pago" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Crear Factura</button>
    </form>
    </div>

    <?php include("../template/pie.php"); ?>