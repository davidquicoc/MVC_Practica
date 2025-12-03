<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', '/Biblioteca_Ej');

function redirigir($path) {
    header("Location: " . BASE_PATH . $path);
    exit();
}
?>