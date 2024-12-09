<?php
require_once "../../config/conexion.php";
require_once "../../models/detallesmodels/Detalle.php";

$detalleModel = new Detalle($conexion);
$detalles = $detalleModel->getAllDetalles();

// Verificar conexión
if ($conexion->connect_error) {
    echo "Error de conexión: " . $conexion->connect_error;
    exit();
}

// Procesar la creación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $detalleModel->createDetalle($_POST['id_factura'], $_POST['num_detalle'], $_POST['id_producto'], $_POST['cantidad'], $_POST['precio']);
    header("Location: index.php");
    exit();
}

// Procesar la edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $detalleModel->updateDetalle($_POST['id_factura'], $_POST['num_detalle'], $_POST['id_producto'], $_POST['cantidad'], $_POST['precio']);
    header("Location: index.php");
    exit();
}

// Procesar la eliminación
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_factura']) && isset($_GET['num_detalle'])) {
    $detalleModel->deleteDetalle($_GET['id_factura'], $_GET['num_detalle']);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Detalles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            transform: translateY(-20px);
            transition: all 0.3s ease-in-out;
        }
        .modal.active .modal-content {
            transform: translateY(0);
        }
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200">
    
<?php include("../template/cabecera.php"); ?>

<div class="flex-1 p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-blue-400">Gestión de Detalles</h1>
        <button onclick="document.getElementById('createModal').classList.add('active')" 
                class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Detalle
        </button>
    </div>

    <!-- Tabla -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-700 text-gray-200 text-sm uppercase">
                        <th class="px-6 py-3 text-left">ID Factura</th>
                        <th class="px-6 py-3 text-left">Número Detalle</th>
                        <th class="px-6 py-3 text-left">ID Producto</th>
                        <th class="px-6 py-3 text-left">Cantidad</th>
                        <th class="px-6 py-3 text-left">Precio</th>
                        <th class="px-6 py-3 text-right w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php foreach ($detalles as $detalle): ?>
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-6 py-4"><?= htmlspecialchars($detalle['id_factura']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($detalle['num_detalle']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($detalle['id_producto']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($detalle['cantidad']) ?></td>
                        <td class="px-6 py-4"><?= number_format($detalle['precio'], 2) ?></td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-2">
                                <button onclick="openEditModal('<?= htmlspecialchars($detalle['id_factura']) ?>', '<?= htmlspecialchars($detalle['num_detalle']) ?>', '<?= htmlspecialchars($detalle['id_producto']) ?>', '<?= htmlspecialchars($detalle['cantidad']) ?>', '<?= htmlspecialchars($detalle['precio']) ?>')" 
                                        class="bg-yellow-500 hover:bg-yellow-600 p-2 rounded transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('<?= htmlspecialchars($detalle['id_factura']) ?>', '<?= htmlspecialchars($detalle['num_detalle']) ?>')"
                                        class="bg-red-600 hover:bg-red-700 p-2 rounded transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear -->
    <div id="createModal" class="modal fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-gray-700 rounded-lg w-full max-w-md mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">Crear Detalle</h2>
                <form method="POST" onsubmit="return validateForm(this)">
                    <input type="hidden" name="action" value="create">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">ID Factura</label>
                            <input name="id_factura" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Número Detalle</label>
                            <input name="num_detalle" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ID Producto</label>
                            <input name="id_producto" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Cantidad</label>
                            <input name="cantidad" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Precio</label>
                            <input name="precio" type="number" required min="0" step="0.01"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('createModal')" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="editModal" class="modal fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-gray-700 rounded-lg w-full max-w-md mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">Editar Detalle</h2>
                <form method="POST" onsubmit="return validateForm(this)">
                    <input type="hidden" name="action" value="edit">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">ID Factura</label>
                            <input id="edit_id_factura" name="id_factura" type="number" readonly
                                   class="w-full p-2 rounded bg-gray-600 border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Número Detalle</label>
                            <input id="edit_num_detalle" name="num_detalle" type="number" readonly
                                   class="w-full p-2 rounded bg-gray-600 border border-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ID Producto</label>
                            <input id="edit_id_producto" name="id_producto" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Cantidad</label>
                            <input id="edit_cantidad" name="cantidad" type="number" required min="1"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Precio</label>
                            <input id="edit_precio" name="precio" type="number" required min="0" step="0.01"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('editModal')" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-lg transition-colors duration-200">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm(form) {
        const inputs = form.querySelectorAll('input[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                alert('Por favor, complete todos los campos requeridos.');
                return false;
            }
            if (input.type === 'number' && input.min && parseFloat(input.value) < parseFloat(input.min)) {
                alert('Los valores numéricos deben ser mayores o iguales a ' + input.min);
                return false;
            }
        }
        return true;
    }

    function openEditModal(id_factura, num_detalle, id_producto, cantidad, precio) {
        document.getElementById('edit_id_factura').value = id_factura;
        document.getElementById('edit_num_detalle').value = num_detalle;
        document.getElementById('edit_id_producto').value = id_producto;
        document.getElementById('edit_cantidad').value = cantidad;
        document.getElementById('edit_precio').value = precio;
        document.getElementById('editModal').classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function confirmDelete(id_factura, num_detalle) {
        if (confirm('¿Está seguro de que desea eliminar este detalle?')) {
            window.location.href = `?action=delete&id_factura=${id_factura}&num_detalle=${num_detalle}`;
        }
    }

    // Cerrar modales al hacer clic fuera
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    // Prevenir scroll cuando el modal está abierto
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('wheel', (e) => {
            if (e.target === modal) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
