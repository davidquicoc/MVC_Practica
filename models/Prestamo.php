<?php
require_once __DIR__ . '/../config/config.php';

class Prestamo {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function sacar(array $data) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];
        $fecha_devolucion = $data['fecha_devolucion'];
        $multa = $data['multa'];

        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$multa')");
    }
}
?>