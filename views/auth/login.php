<?php
$error = $_SESSION['error'] ?? '';
$register_confirm = $_SESSION['register-confirm'] ?? '';
unset($_SESSION['error']);
unset($_SESSION['register-confirm']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Biblioteca</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/auth.css">
</head>
<body>
    <div class="container">
        <form action="<?= BASE_PATH ?>/index.php?action=do-login" method="POST">
            <h2>Inicia sesión</h2>
            <?php
                if ($error !== '') {
                    echo "<p class='error-text'>$error</p>";
                }
                if ($register_confirm !== '') {
                    echo "<p class='register-text'>$error</p>";
                }
            ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" required>
            <div class="button-block">
                <input type="submit" value="Acceder">
            </div>
            <p>¿No tienes una cuenta de usuario? <a href="<?= BASE_PATH ?>/index.php?action=register">Regístrate</a></p>
        </form>
    </div>
</body>
</html>