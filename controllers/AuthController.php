<?php
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    
    //  Muestra la vista de login
    public function mostrarLogin() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    //  Muestra la vista de register
    public function mostrarRegister() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    //  Introduce los datos en la sesión de la página web
    public function hacerLogin() {
        $email = $_POST['email'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        
        if (empty($email) || empty($contraseña)) {
            $_SESSION['error'] = "Campo email o/y contraseña vacíos.";
            redirigir('/index.php?action=login');
            return;
        }

        $usuarioMod = new Usuario();
        $usuario = $usuarioMod->obtenerUsuarioPorEmail($email);

        if ($usuario != null && password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['user'] = $usuario;
            $_SESSION['user']['nombre'] = $usuario['nombre'];
            redirigir('/index.php');
        } else {
            $_SESSION['error'] = "Usuario no encontrado.";
            redirigir('/index.php?action=login');
        }
    }

    //  Registra un usuario a la base de datos
    public function hacerRegister() {
        $formulario = [
            'dni' => $_POST['dni'] ?? '',
            'nombre' => $_POST['nombre'] ?? '',
            'apellido' => $_POST['apellido'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contraseña' => $_POST['contraseña'] ?? ''
        ];

        if (empty($formulario['dni']) || empty($formulario['nombre']) || empty($formulario['apellido']) || empty($formulario['email']) || empty($formulario['contraseña'])) {
            $_SESSION['error'] = "Hay algunos campos vacíos del formulario.";
            redirigir('/index.php?action=register');
            return;
        }
        
        $usuarioMod = new Usuario();

        if ($usuarioMod->existeEmail($formulario['email'])) {
            $_SESSION['error'] = "Correo ya asignado a un usuario.";
            redirigir('/index.php?action=register');
            return;
        }

        if ($usuarioMod->crearUsuario($formulario)) {
            $_SESSION['register-confirm'] = "Registro confirmado.";
            redirigir('/index.php?action=login');
        } else {
            $_SESSION['error'] = "Error en la creación de usuario.";
            redirigir('/index.php?action=register');
        }
    }

    //  Destruye la sesión de la página web
    public function logout() {
        session_unset();
        session_destroy();
        redirigir('/index.php');
    }

}

?>