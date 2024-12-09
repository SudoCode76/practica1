<?php
require_once "../../config/conexion.php"; // Asegúrate de que la ruta es correcta
// Importa el modelo ProductoModel
require_once "../../models/productomodels/producto.php";
class ProductoController {
    private $conexion;
    private $productoModel;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->productoModel = new ProductoModel($conexion);
    }

    public function create($data) {
        return $this->productoModel->create($data['nombre'], $data['precio'], $data['stock'], $data['id_categoria']);
    }

    public function read() {
        return $this->productoModel->read();
    }

    public function update($id, $data) {
        return $this->productoModel->update($id, $data['nombre'], $data['precio'], $data['stock'], $data['id_categoria']);
    }

    public function delete($id) {
        return $this->productoModel->delete($id);
    }
}
?>