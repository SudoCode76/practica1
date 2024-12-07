<?php
require_once __DIR__ . '/loginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if ($username && $password) {
        $controller = new LoginController();
        $user = $controller->login($username, $password);

        if ($user) {
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['rol'] = $user['nombre_rol']; 
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            header("Location: ../views/login/login.php?error=1");
            exit();
        }
    } else {
        header("Location: ../views/login/login.php?error=1");
        exit();
    }
}
?>
