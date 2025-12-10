<?php
    require_once __DIR__ . '/../core/session.php';
    require_once __DIR__ . '/../models/Usuario.php';
    require_once __DIR__ . '/../models/Libro.php';
    require_once __DIR__ . '/../models/Prestamo.php';

    class PrestamoController {
        public function mostrarIndexPrestamos() {
            require_login();

            $librosDisponibles = (new Libro())->obtenerLibrosDisponibles();
            $usuariosActuales = (new Usuario())->obtenerTodosLosUsuarios();

            $librosPrestados = (new Prestamo())->obtenerPrestamosPorUsuario($_SESSION['user']['id']);

            $prestamos = (new Prestamo())->listarPrestamos();
            require __DIR__ . '/../views/prestamos/index.php';
        }

        public function sacarLibro() {
            $formulario = [
                'usuario_id' => $_POST['usuario_id'] ?? '',
                'libro_id' => $_POST['libro_id'] ?? '',
                'fecha_prestamo' => $_POST['fecha_prestamo'] ?? '',
                'fecha_devolucion' => $_POST['fecha_devolucion'] ?? '',
                'multa' => $_POST['multa'] ?? 0
            ];

            $libroMod = new Libro();
            
            $comprobacionLibro = $libroMod->obtenerLibrosDisponibles();
            $esDisponible = false;

            foreach ($comprobacionLibro as $comprobacion) {
                if ($comprobacion['id'] === $formulario['libro_id']) {
                    $esDisponible = true;
                    break;
                }
            }

            if (!$esDisponible) {
                $_SESSION['prestamo-error'] = "Libro no encontrado o libro no disponible";
                redirigir('/index.php?action=prestamos');
                return;
            }

            $prestamoMod = new Prestamo();
            
            if ($prestamoMod->sacarLibro($formulario)) {
                $libroMod->actualizarDisponibilidad($formulario['libro_id'], 0);
                $_SESSION['prestamo-mensaje'] = "Préstamo añadido correctamente";
            } else {
                $_SESSION['prestamo-error'] = "Error al añadir préstamo";
            }
            redirigir('/index.php?action=prestamos');
        }

        public function devolverLibro() {}
    }
?>
