<?php

class Detalle
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Obtener todos los detalles
    public function getAllDetalles()
    {
        $query = "SELECT * FROM DETALLE";
        $result = $this->conexion->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener un detalle por su ID
    public function getDetalleById($id_factura, $num_detalle)
    {
        $query = "SELECT * FROM DETALLE WHERE id_factura = ? AND num_detalle = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('ii', $id_factura, $num_detalle);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Crear un nuevo detalle
    public function createDetalle($id_factura, $num_detalle, $id_producto, $cantidad, $precio)
    {
        $query = "INSERT INTO DETALLE (id_factura, num_detalle, id_producto, cantidad, precio)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('iiidi', $id_factura, $num_detalle, $id_producto, $cantidad, $precio);
        $stmt->execute();
    }

    // Actualizar un detalle
    public function updateDetalle($id_factura, $num_detalle, $id_producto, $cantidad, $precio)
    {
        $query = "UPDATE DETALLE SET id_producto = ?, cantidad = ?, precio = ? 
                  WHERE id_factura = ? AND num_detalle = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('iidii', $id_producto, $cantidad, $precio, $id_factura, $num_detalle);
        $stmt->execute();
    }

    // Eliminar un detalle
    public function deleteDetalle($id_factura, $num_detalle)
    {
        $query = "DELETE FROM DETALLE WHERE id_factura = ? AND num_detalle = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('ii', $id_factura, $num_detalle);
        $stmt->execute();
    }
}
