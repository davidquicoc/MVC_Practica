<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="David Manuel Quico Cuya">
    <meta name="website" content="Gestión de libros de una biblioteca">
    <meta name="description" content="Práctica Modelo Vista Controlador con Docker">    
    <title><?php echo $tituloPagina; ?></title>
    <?php if ($cssFile == 'I') { ?>
        <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    <?php } elseif ($cssFile == 'L') { ?>
        <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/libros.css">
    <?php } elseif ($cssFile == 'P') { ?>
        <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/prestamos.css">
    <?php } ?>
    <link rel="icon" type="image/png" href="<?= BASE_PATH ?>/assets/images/website/icon_website.png">
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="header-logo">
                <img src="<?= BASE_PATH ?>/assets/images/website/logo_website.png" alt="logo_website">
                <h2>Biblioteca</h2>
            </div>
            <nav class="header-navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php if (!empty($_SESSION['user'])) { ?>
                        <li><a href="index.php?action=libros">Libros</a></li>
                        <li><a href="index.php?action=prestamos">Préstamos</a></li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="header-user">
                <?php
                if (!empty($_SESSION['user'])) {
                    echo "<p>" . $_SESSION['user']['nombre'] . " (<a href='" . BASE_PATH . "/index.php?action=logout'>Cerrar sesión</a>)</p>";
                } else {
                    echo "<p><a href='" . BASE_PATH . "/index.php?action=login'>Iniciar sesión</a></p>";
                }
                ?>
            </div>
        </header>
        <main class="main">