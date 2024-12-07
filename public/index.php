<?php

// Incluir archivos necesarios
require_once '../app/controllers/HomeController.php';
// Agrega otros controladores según sea necesario

// Definir BASE_URL
define('BASE_URL', '/PRACTICA1/public');

$fullUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$scriptName = $_SERVER['SCRIPT_NAME']; 

$basePath = str_replace('index.php', '', $scriptName); 

if (strpos($fullUri, $basePath) === 0) {
    $uri = substr($fullUri, strlen($basePath));
} else {
    $uri = $fullUri;
}

if ($uri === '' || $uri === '/') {
    $uri = '/';
}


// Simple enrutador
if ($uri === '/' || $uri === '/home') {
    $controller = new HomeController();
    $controller->index();
} else {
    // Manejar 404
    header("HTTP/1.0 404 Not Found");
    echo 'Página no encontrada';
}
