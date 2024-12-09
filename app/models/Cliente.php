<?php
class Cliente {
    private $conn;
    private $table_name = "cliente";
    
    private $id_cliente;
    private $nombre;
    private $apellido;
    private $direccion;
    private $fecha_nacimiento;
    private $telefono;
    private $email;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Getters y setters
    public function setId($id) { $this->id_cliente = $id; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setFechaNacimiento($fecha) { $this->fecha_nacimiento = $fecha; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setEmail($email) { $this->email = $email; }
    
    // Create
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                (nombre, apellido, direccion, fecha_nacimiento, telefono, email) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", 
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->fecha_nacimiento,
            $this->telefono,
            $this->email
        );
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    
    // Read all
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_cliente DESC";
        $result = $this->conn->query($query);
        return $result;
    }
    
    // Read one
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($row) {
            $this->nombre = $row['nombre'];
            $this->apellido = $row['apellido'];
            $this->direccion = $row['direccion'];
            $this->fecha_nacimiento = $row['fecha_nacimiento'];
            $this->telefono = $row['telefono'];
            $this->email = $row['email'];
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    
    // Update
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                SET nombre = ?, 
                    apellido = ?, 
                    direccion = ?, 
                    fecha_nacimiento = ?, 
                    telefono = ?, 
                    email = ? 
                WHERE id_cliente = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssi",
            $this->nombre,
            $this->apellido,
            $this->direccion,
            $this->fecha_nacimiento,
            $this->telefono,
            $this->email,
            $this->id_cliente
        );
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
    
    // Delete
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id_cliente);
        
        if($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }
}
?>
