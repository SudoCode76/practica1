<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: /PRACTICA1/app/views/login/login.php");
    exit();
}

?>
