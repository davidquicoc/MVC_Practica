<?php
    require_once __DIR__ . '/../core/session.php';
    require_once __DIR__ . '/../controllers/PrestamoController.php';
    require_once __DIR__ . '/../models/Usuario.php';
    require_once __DIR__ . '/../models/Libro.php';
    require_once __DIR__ . '/../models/Prestamo.php';

    class PrestamoController {
        public function mostrarIndexPrestamos() {
            require_login();

            $librosDisponibles = (new Libro())->obtenerLibrosDisponibles();
            $usuariosActuales = (new Usuario())->obtenerTodosLosUsuarios();
            require __DIR__ . '/../views/prestamos/index.php';
        }

        public function sacarLibro() {
            $formulario = [
                'usuario_id' => $_POST['usuario_id'] ?? '',
                'libro_id' => $_POST['libro_id'] ?? '',
                'fecha_prestamo' => $_POST['fecha_prestamo'] ?? '',
                'fecha_devolucion' => $_POST['fecha_devolucion'] ?? '',
                'multa' => $_POST['multa'] 
            ];

            $libroMod = new Libro();
            $comprobacionLibro = $libroMod->obtenerLibrosDisponibles();
            $esDisponible = false;

            foreach ($comprobacionLibro as $comprobacion) {
                if ($comprobacion['libro_id'])
            }

            $prestamoMod = new Prestamo();
            if ($prestamoMod()->sacar($formulario)) {

            }
        }

        public function devolverLibro() {}
    }
?>