<?php
class Categoria {
    private $conn;
    private $table_name = "categoria";
    
    private $id;
    private $nombre;
    private $descripcion;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Getters y setters
    public function setId($id) { $this->id = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    
    // Create
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $this->nombre, $this->descripcion);
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    
    // Read all
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Update
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $this->nombre, $this->descripcion, $this->id);
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    
    // Delete
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
}
?> 