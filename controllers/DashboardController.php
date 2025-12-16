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

        //  Lista completa de libros
        $listaDeLibros = (new Libro())->obtenerLibros();
        //  Cantidad total de libros
        $totalLibrosExistentes = (new Libro())->contarLibros();        
        //  Cantidad total de libros disponibles
        $totalLibrosDisponibles = (new Libro())->contarLibrosSegunDisponibilidad(1);
        //  Cantidad total de libros no disponibles
        $totalLibrosNoDisponibles = (new Libro())->contarLibrosSegunDisponibilidad(0);
        
        //  Cantidad total de usuarios en la BD
        $totalUsuariosExistentes = (new Usuario())->contarUsuarios();
        //  Cantidad total de préstamos en la BD
        $totalPrestamosExistentes = (new Prestamo())->contarPrestamos();

        //  Guardar en un array los préstamos pendientes
        $prestamosDelUsuario = [];
        if (isset($_SESSION['user'])) {
            $prestamosDelUsuario = (new Prestamo())->obtenerActivosUsuario($_SESSION['user']['id']);
        }
        require __DIR__ . '/../views/index.php';
    }
}
?>