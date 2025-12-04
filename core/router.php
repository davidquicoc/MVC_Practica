<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/BookController.php';

$action = $_GET['action'] ?? null;

switch($action) {
    //  Login & Register
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
    //  Libro
    case 'create-libro':
        (new BookController())->mostrarCrear();
        break;
    //  Default
    default:
        require_once __DIR__ . '/../views/index.php';
        break;
}
