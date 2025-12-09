<?php
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Prestamo.php';

class DashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $totalLibros = (new Libro())->contarLibros();        
        $totalUsuarios = (new Usuario())->contarUsuarios();
        $totalLibrosDisponibles = (new Libro())->contarLibros();
        $totalLibrosDisponibles = (new Libro())->contarLibrosDisponibles();
        $totalLibrosNoDisponibles = (new Libro())->contarLibrosNoDisponibles();
        $totalPrestamosExistentes = (new Prestamo())->totalDePrestamosExistentes();
        require __DIR__ . '/../views/index.php';
    }
}
?>