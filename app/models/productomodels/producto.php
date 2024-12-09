<?php
class ProductoModel {
    private $conexion; // Variable para la conexión

    // Constructor que recibe la conexión
    public function __construct($conexion) {
        $this->conexion = $conexion; // Asigna la conexión a la variable de la clase
    }

    // Método para crear un nuevo producto
    public function create($nombre, $precio, $stock, $id_categoria) {
        $query = "INSERT INTO producto (nombre, precio, stock, id_categoria) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("sdii", $nombre, $precio, $stock, $id_categoria); // 'sdii' indica tipos de datos

        return $stmt->execute();
    }

    // Método para leer todos los productos
    public function read() {
        $query = "SELECT * FROM producto";
        $result = $this->conexion->query($query);
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve todos los productos
    }

    // Método para actualizar un producto existente
    public function update($id, $nombre, $precio, $stock, $id_categoria) {
        $query = "UPDATE producto SET nombre = ?, precio = ?, stock = ?, id_categoria = ? WHERE id_producto = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("sdiii", $nombre, $precio, $stock, $id_categoria, $id);

        return $stmt->execute();
    }

    // Método para eliminar un producto
    public function delete($id) {
        $query = "DELETE FROM producto WHERE id_producto = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero

        return $stmt->execute();
    }
}
?>