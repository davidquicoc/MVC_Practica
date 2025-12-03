<?php
$tituloPagina = "Libro | Biblioteca";
require_once __DIR__ . '/core/session.php';
require_once __DIR__ . '/controllers/BookController.php';

$controlador = new BookController();
$controlador->edit();
?>