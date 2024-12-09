<?php
require_once "../../config/conexion.php";
require_once "../../models/productomodels/producto.php";
require_once "../../controllers/producto/productoController.php";

// Modelo
$controller = new ProductoController($conexion);

// Procesar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $controller->create([
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'stock' => $_POST['stock'],
            'id_categoria' => $_POST['id_categoria']
        ]);
    } elseif ($_POST['action'] === 'edit') {
        $id = $_POST['id_producto'];
        $data = [
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'stock' => $_POST['stock'],
            'id_categoria' => $_POST['id_categoria']
        ];
        $controller->update($id, $data);
    }
}

// Procesar eliminación
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $controller->delete($_GET['id_producto']);
}

// Obtener todos los productos
$productos = $controller->read();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">

<?php include("../template/cabecera.php"); ?>
<div class="container mx-auto p-4 sm:p-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-green-400">Gestión de Productos</h1>

    <!-- Botón para abrir el modal de creación -->
    <div class="mb-6">
        <button onclick="openModal('create')" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transition duration-300 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Crear Producto
        </button>
    </div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto">
        <!-- Vista móvil (cards) -->
        <div class="md:hidden space-y-4">
            <?php foreach ($productos as $producto): ?>
                <div class="bg-gray-800 rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-lg"><?= $producto['nombre'] ?></h3>
                        <span class="text-gray-400 text-sm">#<?= $producto['id_producto'] ?></span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p>Precio: $<?= $producto['precio'] ?></p>
                        <p>Stock: <?= $producto['stock'] ?></p>
                        <p>Categoría: <?= $producto['id_categoria'] ?></p>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($producto)) ?>)" 
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </button>
                        <a href="?action=delete&id_producto=<?= $producto['id_producto'] ?>" 
                           class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-center transition duration-300"
                           onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Vista desktop (tabla) -->
        <table class="hidden md:table w-full table-auto bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Precio</th>
                    <th class="px-4 py-3 text-left">Stock</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-750 transition duration-200">
                        <td class="px-4 py-3"><?= $producto['id_producto'] ?></td>
                        <td class="px-4 py-3"><?= $producto['nombre'] ?></td>
                        <td class="px-4 py-3">$<?= $producto['precio'] ?></td>
                        <td class="px-4 py-3"><?= $producto['stock'] ?></td>
                        <td class="px-4 py-3"><?= $producto['id_categoria'] ?></td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="openEditModal(<?= htmlspecialchars(json_encode($producto)) ?>)" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg transition duration-300 mr-2 inline-flex items-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <a href="?action=delete&id_producto=<?= $producto['id_producto'] ?>" 
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg inline-flex items-center transition duration-300"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para crear/editar producto -->
<div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-gray-800 rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h2 id="modal-title" class="text-2xl font-bold text-green-400">Crear Producto</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form method="POST" id="modal-form" class="space-y-4">
            <input type="hidden" name="action" id="action" value="create">
            <input type="hidden" name="id_producto" id="id_producto">
            
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-medium">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="precio" class="block text-sm font-medium">Precio:</label>
                <input type="number" step="0.01" name="precio" id="precio" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="stock" class="block text-sm font-medium">Stock:</label>
                <input type="number" name="stock" id="stock" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="id_categoria" class="block text-sm font-medium">Categoría:</label>
                <input type="number" name="id_categoria" id="id_categoria" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </button>
                <button type="submit" 
                        class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="submitButtonText">Guardar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(action) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
    document.getElementById('action').value = action;
    document.getElementById('modal-title').textContent = action === 'create' ? 'Crear Producto' : 'Editar Producto';
    document.getElementById('submitButtonText').textContent = action === 'create' ? 'Guardar' : 'Actualizar';
    if (action === 'create') {
        document.getElementById('modal-form').reset();
    }
}

function openEditModal(producto) {
    openModal('edit');
    document.getElementById('id_producto').value = producto.id_producto;
    document.getElementById('nombre').value = producto.nombre;
    document.getElementById('precio').value = producto.precio;
    document.getElementById('stock').value = producto.stock;
    document.getElementById('id_categoria').value = producto.id_categoria;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Cerrar modal al hacer clic fuera
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

</body>
</html>