<?php
require_once __DIR__ . '/../core/session.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Prestamo.php';

class PrestamoController {

    //  Mostrar la vista de prestamos
    public function mostrarIndexPrestamos() {
        require_login();

        $librosDisponibles = (new Libro())->obtenerIdTituloDeLibrosDisponibles();
        $usuariosActuales = (new Usuario())->obtenerIdNombreDeLosUsuarios();

        $usuarioLoginPrestamos = (new Prestamo())->obtenerActivosUsuario($_SESSION['user']['id']);
        $prestamosPendientes = (new Prestamo())->obtenerPendientes();
        $prestamosHistorial = (new Prestamo())->obtenerHistorial();

        require __DIR__ . '/../views/prestamos/index.php';
    }

    //  Saca un libro añadiendo un préstamo al usuario y actualiza la disponibilidad de un libro
    public function sacarLibro() {
        $multaInput = $_POST['multa'] ?? '';

        if (!is_numeric($multaInput)) {
            $_SESSION['prestamo-error'] = "El valor de la multa debe ser numérico.";
            redirigir('/index.php?action=prestamos');
            return;
        }
        
        $multa = floatval($multaInput);

        if ($multa <= 0) {
            $_SESSION['prestamo-error'] = "La multa debe ser un valo mayor a 0.";
            redirigir('/index.php?action=prestamos');
            return;
        }

        if ($multa > 99999.99) {
            $_SESSION['prestamo-error'] = "La multa excede el límite permitido (Máx.: 99999.99€).";
            redirigir('/index.php?action=prestamos');
            return;
        }

        $formulario = [
            'usuario_id' => $_POST['usuario_id'] ?? '',
            'libro_id' => $_POST['libro_id'] ?? '',
            'fecha_prestamo' => $_POST['fecha_prestamo'] ?? '',
            'fecha_devolucion' => $_POST['fecha_devolucion'] ?? '',
            'fecha_devolucion_limite' => $_POST['fecha_devolucion_limite'] ?? '',
            'multa' => $multa
        ];

        if (empty($formulario['usuario_id']) || empty($formulario['libro_id']) || 
            empty($formulario['fecha_prestamo']) || empty($formulario['fecha_devolucion']) || 
            empty($formulario['fecha_devolucion_limite'])) {
            
            $_SESSION['prestamo-error'] = "Todos los campos (usuario, libro y fechas) son obligatorios.";
            redirigir('/index.php?action=prestamos');
            return;
        }

        if ($formulario['fecha_prestamo'] > $formulario['fecha_devolucion']) {
            $_SESSION['prestamo-error'] = "La fecha de préstamo no puede ser mayor a la fecha de devolución.";
            redirigir('/index.php?action=prestamos');
            return;
        }

        if ($formulario['fecha_devolucion'] > $formulario['fecha_devolucion_limite']) {
            $_SESSION['prestamo-error'] = "La fecha de aviso no puede ser mayor a la fecha límite.";
            redirigir('/index.php?action=prestamos');
            return;
        }

        $libroMod = new Libro();
        $comprobacionLibro = $libroMod->obtenerIdTituloDeLibrosDisponibles();
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

        $prestamoMod = new Prestamo();
        if ($prestamoMod->sacar($formulario)) {
            $libroMod->actualizarDisponibilidad($formulario['libro_id'], 0);
            $_SESSION['prestamo-mensaje'] = "Préstamo añadido correctamente.";
        } else {
            $_SESSION['prestamo-error'] = "Error al añadir un préstamo.";
        }
        redirigir('/index.php?action=prestamos');
    }

    //  Devuelve el libro y actualiza su disponibilidad
    public function devolverLibro() {
        $prestamo_id = $_POST['prestamo_id'] ?? '';
        $libro_id = $_POST['libro_id'] ?? '';

        $libroMod = new Libro();

        $comprobacionLibro = $libroMod->obtenerIdTituloDeLibrosDisponibles();
        $estaDisponible = false;

        foreach ($comprobacionLibro as $comprobacion) {
            if ($comprobacion['id'] == $libro_id) {
                $estaDisponible = true;
                break;
            }
        }

        if ($estaDisponible) {
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