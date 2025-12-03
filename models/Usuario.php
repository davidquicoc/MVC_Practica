<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function encontrarPorEmail($email) {
        $result = $this->db->query("SELECT * FROM usuario WHERE email = '$email'");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function encontrarPorId($id) {
        $result = $this->db->query("SELECT * FROM usuario WHERE id = '$id'");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function crearUsuario(array $data) {
        $dniU = $data['dni'];
        $nombreU = $data['nombre'];
        $apellidoU = $data['apellido'];
        $emailU = $data['email'];
        $contraseñaU = password_hash($data['contraseña'], PASSWORD_DEFAULT);

        return $this->db->query("INSERT INTO usuario (dni, nombre, apellido, email, contraseña) VALUES ('$dniU', '$nombreU', '$apellidoU', '$emailU', '$contraseñaU')");
        
    }
}
?>