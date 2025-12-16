<?php
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Prestamo.php';

//  Controlador que muestra la vista de la página inicial de la biblioteca
class DashboardController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $listaDeLibros = (new Libro())->obtenerLibros();

        $totalLibrosExistentes = (new Libro())->contarLibros();        
        $totalUsuariosExistentes = (new Usuario())->contarUsuarios();
        $totalPrestamosExistentes = (new Prestamo())->contarPrestamos();

        $totalLibrosDisponibles = (new Libro())->contarLibrosSegunDisponibilidad(1);
        $totalLibrosNoDisponibles = (new Libro())->contarLibrosSegunDisponibilidad(0);
        
        $prestamosDelUsuario = [];
        if (isset($_SESSION['user'])) {
            $prestamosDelUsuario = (new Prestamo())->obtenerActivosUsuario($_SESSION['user']['id']);
        }
        require __DIR__ . '/../views/index.php';
    }
}
?>