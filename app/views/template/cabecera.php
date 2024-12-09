<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .sidebar-text {
                display: none;
            }
            .nav-link {
                padding: 0.75rem !important;
                justify-content: center;
            }
            .nav-icon {
                margin: 0 !important;
            }
            .sidebar-header, .sidebar-footer {
                display: none;
            }
            .sidebar {
                width: 4rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar bg-gray-800 shadow-xl w-48 flex flex-col">
            <!-- Header -->
            <div class="sidebar-header p-4">
                <h1 class="text-lg font-bold text-white">Dashboard</h1>
                <p class="text-xs text-gray-400">Sistema de Gestión</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1">
                <ul class="space-y-2 px-2">
                    <li>
                        <a href="/practica1/app/views/dashboard.php" class="nav-link flex items-center p-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                            <svg class="nav-icon w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="sidebar-text text-sm">Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="/practica1/app/views/categoria" class="nav-link flex items-center p-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                            <svg class="nav-icon w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span class="sidebar-text text-sm">Categorías</span>
                        </a>
                    </li>
                    <li>
                        <a href="/practica1/app/views/producto" class="nav-link flex items-center p-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                            <svg class="nav-icon w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="sidebar-text text-sm">Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="/practica1/app/views/cliente" class="nav-link flex items-center p-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                            <svg class="nav-icon w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span class="sidebar-text text-sm">Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/practica1/app/views/detalle" class="nav-link flex items-center p-2 text-gray-400 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                            <svg class="nav-icon w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span class="sidebar-text text-sm">Detalles</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Footer -->
            <div class="sidebar-footer p-4 border-t border-gray-700">
                <p class="text-xs text-gray-400"> 2024 Sistema de Gestión</p>
            </div>
        </div>