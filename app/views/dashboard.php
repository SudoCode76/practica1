<?php
require_once __DIR__ . '../../config/checkSession.php';
require_once __DIR__ . '../../config/conexion.php';

// Obtener estadísticas
$totalProductos = $conexion->query("SELECT COUNT(*) as total FROM producto")->fetch_assoc()['total'];
$totalCategorias = $conexion->query("SELECT COUNT(*) as total FROM categoria")->fetch_assoc()['total'];
$totalClientes = $conexion->query("SELECT COUNT(*) as total FROM cliente")->fetch_assoc()['total'];

// Productos más vendidos (simplificado por ahora)
$productosPopulares = $conexion->query("
    SELECT nombre, precio 
    FROM producto 
    ORDER BY precio DESC 
    LIMIT 5
");
?>

<?php include("../views/template/cabecera.php"); ?>

<div id="main-content" class="flex-1 p-8 overflow-auto bg-gray-900">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400">Bienvenido al panel de control</p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Productos -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-900 text-blue-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Total Productos</p>
                    <p class="text-2xl font-semibold text-white"><?= $totalProductos ?></p>
                </div>
            </div>
        </div>

        <!-- Total Categorías -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-900 text-green-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Total Categorías</p>
                    <p class="text-2xl font-semibold text-white"><?= $totalCategorias ?></p>
                </div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-900 text-purple-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-400">Total Clientes</p>
                    <p class="text-2xl font-semibold text-white"><?= $totalClientes ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Productos Destacados -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Productos Destacados</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Precio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php while ($producto = $productosPopulares->fetch_assoc()): ?>
                        <tr class="bg-gray-800 hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $producto['nombre'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">$<?= number_format($producto['precio'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categorías -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-white mb-4">Categorías</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Productos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php 
                        $categorias = $conexion->query("
                            SELECT c.nombre, COUNT(p.id_producto) as total_productos 
                            FROM categoria c 
                            LEFT JOIN producto p ON c.id_categoria = p.id_categoria 
                            GROUP BY c.id_categoria
                        ");
                        while ($categoria = $categorias->fetch_assoc()): 
                        ?>
                        <tr class="bg-gray-800 hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $categoria['nombre'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400"><?= $categoria['total_productos'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("../views/template/pie.php"); ?>