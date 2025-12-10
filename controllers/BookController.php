<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../models/Libro.php';

class BookController {

    //  Función que muestra el view index de views/libros
    public function mostrarIndexLibros() {
        require_login();

        $listaLibros = (new Libro())->mostrarLibros();
        require __DIR__ . '/../views/libros/index.php';
    }

    //  Función que muestra el view create de views/libros
    public function mostrarCrear() {
        require_login();
        require __DIR__ . '/../views/libros/create.php';
    }

    //  Función que muestra el view edit de views/libros
    public function mostrarEdit() {
        require_login();
        if (!isset($_POST['id'])) {
            $_SESSION['libro-error'] = "Error al intentar editar un libro";
            redirigir('/index.php?action=libros');
        }
        require __DIR__ . '/../views/libros/edit.php';
    }

    //  Función que recoge los datos del formulario views/libros/create
    public function crearLibro() {
        $formulario = [
            'titulo' => $_POST['titulo'] ?? '',
            'autor' => $_POST['autor'] ?? '',
            'editorial' => $_POST['editorial'] ?? '',
            'genero' => $_POST['genero'] ?? '',
            'año_publicacion' => $_POST['año_publicacion'] ?? '',
            'n_paginas' => $_POST['n_paginas'] ?? ''
        ];

        $libroMod = new Libro();
        if ($libroMod->añadirLibro($formulario)) {
            $_SESSION['libro-mensaje'] = "Libro creado correctamente.";
        } else {
            $_SESSION['libro-error'] = "Creación de libro fallado.";
        }
        redirigir('/index.php?action=libros');
    }

    //  Función que recoge los datos del formulario views/libros/edit
    public function editarLibro() {
        $formulario = [
            'id' => $_POST['id'] ?? '',
            'titulo' => $_POST['titulo'] ?? '',
            'autor' => $_POST['autor'] ?? '',
            'editorial' => $_POST['editorial'] ?? '',
            'genero' => $_POST['genero'] ?? '',
            'año_publicacion' => $_POST['año_publicacion'] ?? '',
            'n_paginas' => $_POST['n_paginas'] ?? ''
        ];

        $libroMod = new Libro();
        if ($libroMod->modificarLibro($formulario)) {
            $_SESSION['libro-mensaje'] = "Libro modificado correctamente.";
        } else {
            $_SESSION['libro-error'] = "Fallido la operación de editar libro.";
        }
        redirigir('/index.php?action=libros');
    }

    //  Función que recoge los datos del formulario views/libros/index
    public function borrarLibro() {
        $id = $_POST['id'] ?? '';
        $libroMod = new Libro();
        if ($libroMod->eliminarLibro($id)) {
            $_SESSION['libro-mensaje'] = "Libro borrado correctamente.";
        } else {
            $_SESSION['libro-error'] = "Libro no eliminado.";
        }
        redirigir('/index.php?action=libros');
    }
}
?>