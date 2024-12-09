<?php
require_once '../../config/conexion.php';
require_once '../../models/Categoria.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $categoria = new Categoria($conexion);
    $categoria->setId($data->id);
    
    if($categoria->delete()) {
        http_response_code(200);
        echo json_encode(["message" => "Categoría eliminada con éxito."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "No se pudo eliminar la categoría."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "ID no proporcionado."]);
}
?> 