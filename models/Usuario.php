<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }
/*
    public function buscarEmailIdenticos($email) {
        $result = $this->db->query("SELECT * FROM usuario WHERE email = '$email");
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }*/

    //  Función que comprueba si hay más de un usuario con el mismo email
    public function encontrarPorEmail($email) {
        $result = $this->db->query("SELECT * FROM usuario WHERE email = '$email'");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    //  Función que hara un comando SQL para crear un usuario con los datos del parámetro
    public function crearUsuario(array $data) {
        $dniU = $data['dni'];
        $nombreU = $data['nombre'];
        $apellidoU = $data['apellido'];
        $emailU = $data['email'];
        $contraseñaU = password_hash($data['contraseña'], PASSWORD_DEFAULT);

        return $this->db->query("INSERT INTO usuario (dni, nombre, apellido, email, contraseña) VALUES ('$dniU', '$nombreU', '$apellidoU', '$emailU', '$contraseñaU')");   
    }

    //  Función que cuenta el total de usuairos existentes en la base de datos
    public function contarUsuarios() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM usuario");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Obtener el id y nombre de los usuarios existentes en la base de datos
    public function obtenerTodosLosUsuarios() {
        return $this->db->query("SELECT id, nombre FROM usuario");
    }
}
?>