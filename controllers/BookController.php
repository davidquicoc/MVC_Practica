<?php
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../models/Libro.php';

class BookController {
    public function edit() {
        require_login();
        $userModel = new Usuario();
        $user = $userModel->encontrarPorId($_SESSION['user']['id']);

        require __DIR__ . '/../views/libros/edit.php';
    }
}
?>