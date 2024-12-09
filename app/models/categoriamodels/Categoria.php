<?php
class Categoria
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Obtener todas las categorías
    public function getAllCategorias()
    {
        $stmt = $this->db->prepare("SELECT * FROM categoria");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Devuelve todas las categorías
    }

    // Obtener una categoría por ID
    public function getCategoriaById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc(); // Devuelve una categoría específica
    }

    // Crear una nueva categoría
    public function createCategoria($nombre_categoria, $descripcion)
    {
        $stmt = $this->db->prepare("INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre_categoria, $descripcion);
        return $stmt->execute();
    }

    // Actualizar categoría
    public function updateCategoria($id, $nombre_categoria, $descripcion)
    {
        $stmt = $this->db->prepare("UPDATE categoria SET nombre = ?, descripcion = ? WHERE id_categoria = ?");
        $stmt->bind_param("ssi", $nombre_categoria, $descripcion, $id);
        return $stmt->execute();
    }

    // Eliminar una categoría
    public function deleteCategoria($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categoria WHERE id_categoria = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
