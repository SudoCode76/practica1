<?php
require_once "../../config/conexion.php";
require_once "../../models/categoriamodels/Categoria.php";

$categoriaModel = new Categoria($conexion);
$categorias = $categoriaModel->getAllCategorias();

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    if (!empty($nombre)) {
        $categoriaModel->createCategoria($nombre, $descripcion);
        header("Location: index.php");
        exit();
    }
}

// Editar una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id_categoria = $_POST['id_categoria'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    if (!empty($nombre) && !empty($id_categoria)) {
        $categoriaModel->updateCategoria($id_categoria, $nombre, $descripcion);
        header("Location: index.php");
        exit();
    }
}

// Eliminar una categoría
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_categoria = $_GET['id_categoria'];
    if (!empty($id_categoria)) {
        $categoriaModel->deleteCategoria($id_categoria);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
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
        @media (max-width: 640px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen">
    
<?php include("../template/cabecera.php"); ?>

<div class="flex-1 p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-blue-400">Gestión de Categorías</h1>
        <button onclick="openModal('createModal')" 
                class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Categoría
        </button>
    </div>

    <!-- Tabla de Categorías -->
    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="table-container">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-700 text-gray-200 text-sm uppercase">
                        <th class="px-6 py-3 text-left w-16">ID</th>
                        <th class="px-6 py-3 text-left">NOMBRE</th>
                        <th class="px-6 py-3 text-left">DESCRIPCIÓN</th>
                        <th class="px-6 py-3 text-right w-32">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php foreach ($categorias as $categoria): ?>
                    <tr class="hover:bg-gray-700/50">
                        <td class="px-6 py-4 text-gray-400"><?= htmlspecialchars($categoria['id_categoria']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($categoria['nombre']) ?></td>
                        <td class="px-6 py-4 text-gray-400"><?= htmlspecialchars($categoria['descripcion']) ?></td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end space-x-2">
                                <button onclick="openEditModal('<?= htmlspecialchars($categoria['id_categoria']) ?>', '<?= htmlspecialchars($categoria['nombre']) ?>', '<?= htmlspecialchars($categoria['descripcion']) ?>')" 
                                        class="bg-yellow-500 hover:bg-yellow-600 p-2 rounded transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('<?= htmlspecialchars($categoria['id_categoria']) ?>')"
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

    <!-- Modal Crear Categoría -->
    <div id="createModal" class="modal fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-gray-700 rounded-lg w-full max-w-md mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">Crear Categoría</h2>
                <form method="POST" onsubmit="return validateForm(this)">
                    <input type="hidden" name="action" value="create">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre</label>
                            <input name="nombre" type="text" required maxlength="100"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Descripción</label>
                            <textarea name="descripcion" rows="3" required maxlength="255"
                                      class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('createModal')" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg transition-colors duration-200">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoría -->
    <div id="editModal" class="modal fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="modal-content bg-gray-700 rounded-lg w-full max-w-md mx-auto">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-6">Editar Categoría</h2>
                <form method="POST" onsubmit="return validateForm(this)">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id_categoria" id="edit_id_categoria">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre</label>
                            <input id="edit_nombre" name="nombre" type="text" required maxlength="100"
                                   class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Descripción</label>
                            <textarea id="edit_descripcion" name="descripcion" rows="3" required maxlength="255"
                                      class="w-full p-2 rounded bg-gray-800 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
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

<!-- Scripts -->
<script>
    function validateForm(form) {
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                alert('Por favor, complete todos los campos requeridos.');
                return false;
            }
        }
        return true;
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function openEditModal(id, nombre, descripcion) {
        document.getElementById('edit_id_categoria').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_descripcion').value = descripcion;
        openModal('editModal');
    }

    function confirmDelete(id) {
        if (confirm('¿Está seguro de que desea eliminar esta categoría?')) {
            window.location.href = `?action=delete&id_categoria=${id}`;
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
