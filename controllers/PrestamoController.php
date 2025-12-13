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

            if (empty($formulario['usuario_id']) || empty($formulario['libro_id'])) {
                $_SESSION['prestamo-error'] = "No se detecto el identificador del usuario o libro.";
                redirigir('/index.php?action=prestamos');
            }

            if (empty($formulario['fecha_prestamo']) || empty($formulario['fecha_devolucion'])) {
                $_SESSION['prestamo-error'] = "Las fechas de préstamo y devolución no deben estar vacías.";
                redirigir('/index.php?action=prestamos');
            }

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
                $_SESSION['prestamo-error'] = "Libro no encontrado o libro no disponible.";
                redirigir('/index.php?action=prestamos');
                return;
            }

            if ($formulario['fecha_prestamo'] > $formulario['fecha_devolucion']) {
                $_SESSION['prestamo-error'] = "La fecha de préstamo no puede ser mayor a la fecha de devolución.";
                redirigir('/index.php?action=prestamos');
            }

            $prestamoMod = new Prestamo();
            
            if ($prestamoMod->sacar($formulario)) {
                $libroMod->actualizarDisponibilidad($formulario['libro_id'], 0);
                $_SESSION['prestamo-mensaje'] = "Préstamo añadido correctamente.";
            } else {
                $_SESSION['prestamo-error'] = "Error al añadir un préstamo.";
            }
            redirigir('/index.php?action=prestamos');
        }

        public function devolverLibro() {
            $prestamo_id = $_POST['prestamo_id'] ?? '';
            $libro_id = $_POST['libro_id'] ?? '';

            $libroMod = new Libro();

            $comprobacionLibro = $libroMod->obtenerLibrosDisponibles();
            $noEsDisponible = false;
            foreach ($comprobacionLibro as $comprobacion) {
                if ($comprobacion['id'] !== $libro_id) {
                    $noEsDisponible = true;
                    break;
                }
            }

            if (!$noEsDisponible) {
                $_SESSION['prestamo-error'] = "Libro no encontrado o libro que cuenta con disponibilidad.";
                redirigir('/index.php?action=prestamos');
                return;
            }

            $prestamoMod = new Prestamo();

            if ($prestamoMod->devolver($prestamo_id)) {
                $libroMod->actualizarDisponibilidad($libro_id, 1);
                $_SESSION['prestamo-mensaje'] = "Libro devuelto correctamente.";
            } else {
                $_SESSION['prestamo-error'] = "Error al devolver un libro.";
            }
            redirigir('/index.php?action=prestamos');
        }
    }
?>
