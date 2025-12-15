<?php
//  Iniciar sesión si no hay ninguna sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Definir una constante que sirve como ruta base de la práctica
define('BASE_PATH', '/MVC_Practica');

function redirigir($path) {
    header("Location: " . BASE_PATH . $path);
    exit();
}

function require_login() {
    if (empty($_SESSION['user'])) {
        // Si la sesión está vacía, redirige a la página de login
        redirigir('/index.php?action=login');
    }
}
?>