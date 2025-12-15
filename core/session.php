<?php
//  Iniciar sesión si no hay ninguna sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Obtiene el directorio padre donde se encuentra el script actual (index.php)
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);

//  Recorta las barras '/' o '\' que sobren al final para evitar dobles barras
$basePath = rtrim($scriptDir, '/\\');

//  Definir una constante que sirve como ruta base dinámica de la aplicación
define('BASE_PATH', $basePath);

function redirigir($path) {
    //  Concatena la ruta base dinámica con el destino para generar la URL correcta
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