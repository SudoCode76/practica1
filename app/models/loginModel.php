<?php
require_once __DIR__ . '/../config/conexion.php';

class LoginModel {
    private $conn;

    public function __construct(){
        global $conexion;
        $this->conn = $conexion;
    }

    public function login($username, $password){
        $sql = "SELECT * from usuarios JOIN roles ON usuarios.id_rol = roles.id_rol WHERE usuarios.username = ? AND usuarios.password = ?";


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>
