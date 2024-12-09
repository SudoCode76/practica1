<?php
require_once "../../config/conexion.php";
require_once "../../models/Cliente.php";

// Crear una instancia del modelo con la conexión
$clienteModel = new Cliente($conexion);

// Función para validar datos del cliente
function validarDatosCliente($data) {
    $errores = [];
    
    if (empty($data['nombre'])) {
        $errores[] = "El nombre es requerido";
    }
    if (empty($data['apellido'])) {
        $errores[] = "El apellido es requerido";
    }
    if (empty($data['email'])) {
        $errores[] = "El email es requerido";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }
    if (empty($data['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es requerida";
    }
    
    return $errores;
}

// Función para enviar respuesta JSON
function enviarRespuesta($success, $mensaje, $data = null) {
    $response = [
        'success' => $success,
        'mensaje' => $mensaje,
        'data' => $data
    ];
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // Redirección normal con mensaje en sesión
    session_start();
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo_mensaje'] = $success ? 'success' : 'error';
    header("Location: index.php");
    exit;
}

// Verificación de la conexión
if ($conexion->connect_error) {
    enviarRespuesta(false, "Error de conexión: " . $conexion->connect_error);
}

try {
    // Procesar la creación de un nuevo cliente
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        $errores = validarDatosCliente($_POST);
        
        if (!empty($errores)) {
            enviarRespuesta(false, "Errores de validación", $errores);
        }

        if ($_POST['action'] == 'create') {
            $clienteModel->setNombre(trim($_POST['nombre']));
            $clienteModel->setApellido(trim($_POST['apellido']));
            $clienteModel->setDireccion(trim($_POST['direccion']));
            $clienteModel->setFechaNacimiento($_POST['fecha_nacimiento']);
            $clienteModel->setTelefono(trim($_POST['telefono']));
            $clienteModel->setEmail(trim($_POST['email']));

            if ($clienteModel->create()) {
                enviarRespuesta(true, "Cliente creado con éxito");
            } else {
                enviarRespuesta(false, "Error al crear el cliente");
            }
        }

        // Procesar la edición de un cliente
        if ($_POST['action'] == 'edit') {
            $clienteModel->setId($_POST['id_cliente']);
            $clienteModel->setNombre(trim($_POST['nombre']));
            $clienteModel->setApellido(trim($_POST['apellido']));
            $clienteModel->setDireccion(trim($_POST['direccion']));
            $clienteModel->setFechaNacimiento($_POST['fecha_nacimiento']);
            $clienteModel->setTelefono(trim($_POST['telefono']));
            $clienteModel->setEmail(trim($_POST['email']));

            if ($clienteModel->update()) {
                enviarRespuesta(true, "Cliente actualizado con éxito");
            } else {
                enviarRespuesta(false, "Error al actualizar el cliente");
            }
        }
    }

    // Eliminar un cliente
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        if (!isset($_GET['id_cliente'])) {
            enviarRespuesta(false, "ID de cliente no proporcionado");
        }

        $clienteModel->setId($_GET['id_cliente']);
        if ($clienteModel->delete()) {
            enviarRespuesta(true, "Cliente eliminado con éxito");
        } else {
            enviarRespuesta(false, "Error al eliminar el cliente");
        }
    }

} catch (Exception $e) {
    enviarRespuesta(false, "Error en el servidor: " . $e->getMessage());
}

// Obtener todos los clientes
$clientes = $clienteModel->read();
?>
