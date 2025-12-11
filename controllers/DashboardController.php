<?php
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Prestamo.php';

class DashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $listaDeLibros = (new Libro())->mostrarLibros();

        $totalLibrosExistentes = (new Libro())->contarLibros();        
        $totalUsuariosExistentes = (new Usuario())->contarUsuarios();
        $totalPrestamosExistentes = (new Prestamo())->contarPrestamos();

        $totalLibrosDisponibles = (new Libro())->contarLibrosDisponibles();
        $totalLibrosNoDisponibles = (new Libro())->contarLibrosNoDisponibles();
        
        $prestamosDelUsuario = [];
        if (isset($_SESSION['user'])) {
            $prestamosDelUsuario = (new Prestamo())->obtenerPrestamosPorUsuario($_SESSION['user']['id']);
        }
        require __DIR__ . '/../views/index.php';
    }
}
?>