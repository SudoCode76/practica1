<?php
require_once "../../config/conexion.php";
require_once "../../models/Cliente.php";

// Modelo
$clienteModel = new Cliente($conexion);

// Procesar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $clienteModel->setNombre($_POST['nombre']);
        $clienteModel->setApellido($_POST['apellido']);
        $clienteModel->setDireccion($_POST['direccion']);
        $clienteModel->setFechaNacimiento($_POST['fecha_nacimiento']);
        $clienteModel->setTelefono($_POST['telefono']);
        $clienteModel->setEmail($_POST['email']);
        $clienteModel->create();
    } elseif ($_POST['action'] === 'edit') {
        $clienteModel->setId($_POST['id_cliente']);
        $clienteModel->setNombre($_POST['nombre']);
        $clienteModel->setApellido($_POST['apellido']);
        $clienteModel->setDireccion($_POST['direccion']);
        $clienteModel->setFechaNacimiento($_POST['fecha_nacimiento']);
        $clienteModel->setTelefono($_POST['telefono']);
        $clienteModel->setEmail($_POST['email']);
        $clienteModel->update();
    }
}

// Procesar eliminación
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $clienteModel->setId($_GET['id_cliente']);
    $clienteModel->delete();
}

// Obtener todos los clientes
$clientes = $clienteModel->read();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen">

<?php include("../template/cabecera.php"); ?>
<div class="container mx-auto p-4 sm:p-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-green-400">Gestión de Clientes</h1>

    <!-- Botón para abrir el modal de creación -->
    <div class="mb-6">
        <button onclick="openModal('create')" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transition duration-300 flex items-center justify-center">
            <i class="fas fa-plus mr-2"></i> Crear Cliente
        </button>
    </div>

    <!-- Tabla/Cards de clientes -->
    <div class="overflow-x-auto">
        <!-- Vista móvil (cards) -->
        <div class="md:hidden space-y-4">
            <?php while ($row = $clientes->fetch_assoc()): ?>
                <div class="bg-gray-800 rounded-lg p-4 shadow-lg">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold text-lg"><?= $row['nombre'] ?> <?= $row['apellido'] ?></h3>
                        <span class="text-gray-400 text-sm">#<?= $row['id_cliente'] ?></span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p><i class="fas fa-map-marker-alt w-6"></i> <?= $row['direccion'] ?></p>
                        <p><i class="fas fa-calendar w-6"></i> <?= $row['fecha_nacimiento'] ?></p>
                        <p><i class="fas fa-phone w-6"></i> <?= $row['telefono'] ?></p>
                        <p><i class="fas fa-envelope w-6"></i> <?= $row['email'] ?></p>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row)) ?>)" 
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </button>
                        <a href="?action=delete&id_cliente=<?= $row['id_cliente'] ?>" 
                           class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-center transition duration-300"
                           onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                            <i class="fas fa-trash-alt mr-2"></i> Eliminar
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Vista desktop (tabla) -->
        <table class="hidden md:table w-full table-auto bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Apellido</th>
                    <th class="px-4 py-3 text-left">Dirección</th>
                    <th class="px-4 py-3 text-left">Fecha Nac.</th>
                    <th class="px-4 py-3 text-left">Teléfono</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $clientes->data_seek(0); // Reset the pointer to start
                while ($row = $clientes->fetch_assoc()): 
                ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-750 transition duration-200">
                        <td class="px-4 py-3"><?= $row['id_cliente'] ?></td>
                        <td class="px-4 py-3"><?= $row['nombre'] ?></td>
                        <td class="px-4 py-3"><?= $row['apellido'] ?></td>
                        <td class="px-4 py-3"><?= $row['direccion'] ?></td>
                        <td class="px-4 py-3"><?= $row['fecha_nacimiento'] ?></td>
                        <td class="px-4 py-3"><?= $row['telefono'] ?></td>
                        <td class="px-4 py-3"><?= $row['email'] ?></td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row)) ?>)" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg transition duration-300 mr-2 inline-flex items-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <a href="?action=delete&id_cliente=<?= $row['id_cliente'] ?>" 
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg inline-flex items-center transition duration-300"
                               onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal mejorado -->
<div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 ">
    <div class="bg-gray-800 rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h2 id="modal-title" class="text-2xl font-bold text-green-400">Crear Cliente</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form method="POST" id="modal-form" class="space-y-4">
            <input type="hidden" name="action" id="action" value="create">
            <input type="hidden" name="id_cliente" id="id_cliente">
            
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-medium">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="apellido" class="block text-sm font-medium">Apellido:</label>
                <input type="text" name="apellido" id="apellido" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="direccion" class="block text-sm font-medium">Dirección:</label>
                <input type="text" name="direccion" id="direccion" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="fecha_nacimiento" class="block text-sm font-medium">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="telefono" class="block text-sm font-medium">Teléfono:</label>
                <input type="tel" name="telefono" id="telefono" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium">Email:</label>
                <input type="email" name="email" id="email" required
                       class="w-full bg-gray-700 p-3 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none text-white">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition duration-300">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 rounded-lg transition duration-300">
                    Guardar
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
    document.getElementById('modal-title').textContent = action === 'create' ? 'Crear Cliente' : 'Editar Cliente';
    if (action === 'create') {
        document.getElementById('modal-form').reset();
    }
}

function openEditModal(cliente) {
    openModal('edit');
    document.getElementById('id_cliente').value = cliente.id_cliente;
    document.getElementById('nombre').value = cliente.nombre;
    document.getElementById('apellido').value = cliente.apellido;
    document.getElementById('direccion').value = cliente.direccion;
    document.getElementById('fecha_nacimiento').value = cliente.fecha_nacimiento;
    document.getElementById('telefono').value = cliente.telefono;
    document.getElementById('email').value = cliente.email;
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
