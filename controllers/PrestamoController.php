<?php
    require_once __DIR__ . '/../core/session.php';
    require_once __DIR__ . '/../controllers/PrestamoController.php';
    require_once __DIR__ . '/../models/Usuario.php';
    require_once __DIR__ . '/../models/Libro.php';

    class PrestamoController {
        private Usuario $usuario;
        private Libro $libro;

        public function __construct() {
            $this->usuario = new Usuario();
            $this->libro = new Libro();
        }

        public function mostrarIndexPrestamos() {
            require_login();
            require __DIR__ . '/../views/prestamos/index.php';
        }

        public function mostrarSacarLibro() {
            require_login();
            require __DIR__ . '/../views/prestamos/sacar-libro.php';
        }

        public function sacarLibro() {}

        public function devolverLibro() {}
    }
?>