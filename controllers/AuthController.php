<?php
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    
    public function mostrarLogin() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    public function mostrarRegister() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    public function hacerLogin() {
        $email = $_POST['email'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        
        if (empty($email) || empty($contraseña)) {
            $_SESSION['error'] = 'Email o contraseña vacíos';
            redirigir('/index.php?action=login');
            return;
        }

        $usuarioMod = new Usuario();
        $usuario = $usuarioMod->encontrarPorEmail($email);

        if ($usuario != null && password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['user'] = $usuario;
            redirigir('/index.php');
        } else {
            $_SESSION['error'] = 'Usuario no encontrado';
            redirigir('/index.php?action=login');
        }
    }

    public function hacerRegister() {
        $formulario = [
            'dni' => $_POST['dni'] ?? '',
            'nombre' => $_POST['nombre'] ?? '',
            'apellido' => $_POST['apellido'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contraseña' => $_POST['contraseña'] ?? ''
        ];

        if (empty($formulario['dni']) || empty($formulario['nombre']) || empty($formulario['apellido']) || empty($formulario['email']) || empty($formulario['contraseña'])) {
            $_SESSION['error'] = 'Algún dato del formulario vacío';
            redirigir('/index.php?action=register');
            return;
        }
        
        $usuarioMod = new Usuario();
        if ($usuarioMod->encontrarPorEmail($formulario['email'])) {
            $_SESSION['error'] = "Coreo asignado";
            redirigir('/index.php?action=register');
            return;
        }

        if ($usuarioMod->crearUsuario($formulario)) {
            $_SESSION['register-confirm'] = "Registro confirmado";
            redirigir('/index.php?action=login');
        } else {
            $_SESSION['error'] = 'Creación de usuario fallado';
            redirigir('/index.php?action=register');
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        redirigir('/index.php');
    }

}

?>