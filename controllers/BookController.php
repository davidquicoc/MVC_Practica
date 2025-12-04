<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../models/Libro.php';

class BookController {
    public function mostrarIndex() {
        require_login();

        $libroModel = new Libro();
        $libros = $libroModel->mostrarLibros();

        require __DIR__ . '/../views/libros/index.php';
    }

    public function mostrarCrear() {
        require_login();
        require __DIR__ . '/../views/libros/create.php';
    }

    public function mostrarEdit() {
        require_login();
        require __DIR__ . '/../views/libros/edit.php';
    }

    public function crearLibro() {}

    public function editarLibro() {}

    public function borrarLibro() {}
}
?>