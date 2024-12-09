<?php
require_once '../../config/conexion.php';
require_once '../../models/Categoria.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->nombre) && !empty($data->descripcion)) {
    $categoria = new Categoria($conexion);
    $categoria->setNombre($data->nombre);
    $categoria->setDescripcion($data->descripcion);
    
    if($categoria->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Categoría creada con éxito."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "No se pudo crear la categoría."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos."]);
}
?> 