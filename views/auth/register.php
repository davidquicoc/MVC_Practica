<?php
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Biblioteca</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/auth.css">
</head>
<body>
    <div class="container">
        <form action="<?= BASE_PATH ?>/index.php?action=do-register" method="POST">
            <h2>Regístrate</h2>
            <?php
                if ($error !== '') {
                    echo "<p class='error-text'>$error</p>";
                }
            ?>
            <label for="dni">DNI:</label>
            <input type="text" name="dni" id="dni" required>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" required>
            <div class="button-block">
                <input type="submit" value="Acceder">
            </div> 
            <p>¿Tienes una cuenta de usuario? <a href="<?= BASE_PATH ?>/index.php?action=login">Inicie sesión</a></p>
            </form>
    </div>
</body>
</html>