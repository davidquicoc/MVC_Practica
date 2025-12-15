<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/BookController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/PrestamoController.php';

//  Obtiene el valor del valor del parámetro action mediante la URL
$action = $_GET['action'] ?? null;

switch($action) {
    //  Login & Register - AuthController
    case 'login':
        (new AuthController())->mostrarLogin();
        break;
    case 'register':
        (new AuthController())->mostrarRegister();
        break;
    case 'do-login':
        (new AuthController())->hacerLogin();
        break;
    case 'do-register':
        (new AuthController())->hacerRegister();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    //  Libro - BookController
    case 'libros':
        (new BookController())->mostrarIndexLibros();
        break;
    case 'add-book':
        (new BookController())->mostrarCrear();
        break;
    case 'modify-book':
        (new BookController())->mostrarEdit();
        break;
    case 'create-book':
        (new BookController())->crearLibro();
        break;
    case 'edit-book':
        (new BookController())->editarLibro();
        break;
    case 'delete-book':
        (new BookController())->borrarLibro();
        break;
    //  Prestamo - PrestamoController
    case 'prestamos':
        (new PrestamoController())->mostrarIndexPrestamos();
        break;
    case 'sacar-libro':
        (new PrestamoController())->sacarLibro();
        break;
    case 'devolver-libro':
        (new PrestamoController())->devolverLibro();
        break;
    //  Mostrar index si action es null
    //  index.php - DashboardController
    default:
        (new DashboardController())->index();
        break;
}
