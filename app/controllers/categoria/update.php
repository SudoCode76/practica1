<?php
require_once '../../config/conexion.php';
require_once '../../models/Categoria.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id) && !empty($data->nombre) && !empty($data->descripcion)) {
    $categoria = new Categoria($conexion);
    $categoria->setId($data->id);
    $categoria->setNombre($data->nombre);
    $categoria->setDescripcion($data->descripcion);
    
    if($categoria->update()) {
        http_response_code(200);
        echo json_encode(["message" => "Categoría actualizada con éxito."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "No se pudo actualizar la categoría."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Datos incompletos."]);
}
?> 