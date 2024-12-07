<?php
require_once __DIR__ . '/registerController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $rol = filter_input(INPUT_POST, 'rol', FILTER_VALIDATE_INT);

    // Validar que se hayan recibido todos los datos
    if ($username && $password && $rol) {
        $controller = new RegisterController();
        $registerSuccess = $controller->register($username, $password, $rol);

        if ($registerSuccess) {
            // Registro exitoso, redirigir al login con mensaje de éxito
            header("Location: ../views/login/login.php?success=1");
            exit();
        } else {
            // Error en el registro (usuario ya existe), redirigir con mensaje de error
            header("Location: ../views/register/register.php?error=1");
            exit();
        }
    } else {
        // Datos incompletos, redirigir con mensaje de error
        header("Location: ../views/register/register.php?error=1");
        exit();
    }
}
?>
