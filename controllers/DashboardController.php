<?php
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Usuario.php';

class DashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $totalLibros = (new Libro())->contarLibros();        
        $totalUsuarios = (new Usuario())->contarUsuarios();

        require __DIR__ . '/../views/index.php';
    }
}
?>