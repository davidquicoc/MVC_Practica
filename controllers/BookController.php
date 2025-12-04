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

    /*public function mostrarCrear() {
        require_login();
        require __DIR__ . '/../views/libros/create.php';
    }

    public function mostrarEdit() {
        require_login();
        require __DIR__ . '/../views/libros/edit.php';
    }*/

    public function crearLibro() {
        $tituloL = $_POST['titulo'];
        $autorL = $_POST['autor'];
        $editorialL = $_POST['editorial'];
        $generoL = $_POST['genero'];
        $año_publicacionL = $_POST['año_publicacion'];
        $n_paginasL = $_POST['n_paginas'];

        
    }

    public function editarLibro() {}

    public function borrarLibro() {}
}
?>