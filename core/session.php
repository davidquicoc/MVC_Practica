<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', '/MVC_Practica');

function redirigir($path) {
    header("Location: " . BASE_PATH . $path);
    exit();
}

function require_login() {
    if (empty($_SESSION['user'])) {
        // Si no hay usuario en sesión, redirige al login
        redirigir('/index.php?action=login');
    }
}
?>