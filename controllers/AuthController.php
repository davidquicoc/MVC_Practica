<?php
require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    
    //  Función que muestra el view/auth/login.php
    public function mostrarLogin() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    //  Función que muestra el view/auth/register.php
    public function mostrarRegister() {
        if (!empty($_SESSION['user'])) {
            redirigir('/index.php');
        }
        require __DIR__ . '/../views/auth/register.php';
    }

    //  Función que hará comprobaciones y hara login en $_SESSION con los datos del formulario de login
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

    //  Función que hará comprobaciones y creará un usuario en la base de datos con los datos del formulario de register
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

    public function logout() {
        session_unset();
        session_destroy();
        redirigir('/index.php');
    }

}

?>