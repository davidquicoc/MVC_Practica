<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../models/Libro.php';

class BookController {

    //  Muestra la vista de libros
    public function mostrarIndexLibros() {
        require_login();
        
        $listaLibros = (new Libro())->obtenerLibros();
        require __DIR__ . '/../views/libros/index.php';
    }

    //  Muestra la vista de crear un libro
    public function mostrarCrear() {
        require_login();
        
        require __DIR__ . '/../views/libros/create.php';
    }

    //  Muestra la vista de editar un libro
    public function mostrarEdit() {
        require_login();
        if (!isset($_POST['id'])) {
            $_SESSION['libro-error'] = "No se ha especificado el libro a editar.";
            redirigir('/index.php?action=libros');
        }
        require __DIR__ . '/../views/libros/edit.php';
    }

    //  Crea un libro a la base de datos
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
            $_SESSION['libro-error'] = "Error en la creación del libro.";
        }
        redirigir('/index.php?action=libros');
    }

    //  Modifica un libro de la base de datos
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
        $resultado = $libroMod->modificarLibro($formulario);

        if ($resultado == 2) {
            $_SESSION['libro-mensaje'] = "Libro modificado correctamente.";
        } elseif($resultado == 1) {
            $_SESSION['libro-mensaje'] = "No se realizaron cambios en el libro '" . $formulario['titulo'] . "'.";
        } else {
            $_SESSION['libro-error'] = "Error en la edición del libro.";
        }
        redirigir('/index.php?action=libros');
    }

    //  Borra un libro de la base de datos
    public function borrarLibro() {
        $id = $_POST['id'] ?? '';
        $libroMod = new Libro();
        if ($libroMod->eliminarLibro($id)) {
            $_SESSION['libro-mensaje'] = "Libro borrado correctamente.";
        } else {
            $_SESSION['libro-error'] = "Error al eliminar el libro.";
        }
        redirigir('/index.php?action=libros');
    }
}
?>