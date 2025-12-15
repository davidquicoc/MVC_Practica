<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {

    //  Objeto privado de mysqli
    private mysqli $db;

    public function __construct() {
        global $conn;
        //  Conexión a la base de datos establecida en config.php
        $this->db = $conn;
    }

    //  Devuelve un array asociativo con los datos del usuario si su email coincide, o devuelve NULL
    public function obtenerUsuarioPorEmail($email) {
        $result = $this->db->query("SELECT * FROM usuario WHERE email = '$email'");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    //  Devuelve TRUE/FALSE si existe un usuario con el email indicado
    public function existeEmail($email) {
        $result = $this->db->query("SELECT * FROM usuario WHERE email = '$email'");
        return $result->num_rows > 0;
    }

    //  Devuelve TRUE/FALSE si se insertó el usuario a la base de datos con sus datos pasados en $data
    public function crearUsuario(array $data) {
        $dniU = $data['dni'];
        $nombreU = $data['nombre'];
        $apellidoU = $data['apellido'];
        $emailU = $data['email'];
        $contraseñaU = password_hash($data['contraseña'], PASSWORD_DEFAULT);

        return $this->db->query("INSERT INTO usuario (dni, nombre, apellido, email, contraseña) VALUES ('$dniU', '$nombreU', '$apellidoU', '$emailU', '$contraseñaU')");   
    }

    //  Devuelve en número entero, el total de usuarios en la base de datos
    public function contarUsuarios() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM usuario");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Devuelve el id y nombre de todos los usuarios de la base de datos
    public function obtenerIdNombreDeLosUsuarios() {
        return $this->db->query("SELECT id, nombre FROM usuario");
    }
}
?>