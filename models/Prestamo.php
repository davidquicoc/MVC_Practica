<?php
require_once __DIR__ . '/../config/config.php';

class Prestamo {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function sacarLibro(array $data) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];
        $fecha_devolucion = $data['fecha_devolucion'];
        $multa = $data['multa'];

        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$multa')");
    }

    public function totalDePrestamosExistentes() {
        $result = $this->db->query("SELECT COUNT(*) AS 'total' FROM prestamo");
        if ($result) {
            return $result->fetch_assoc();
        }
        return 0;
    }

    public function listarPrestamos() {
        return $this->db->query("SELECT prestamo.id AS prestamo_id,
                                    usuario.nombre AS nombre_usuario,
                                    libro.titulo AS titulo_libro,
                                    prestamo.fecha_prestamo,
                                    prestamo.fecha_devolucion,
                                    prestamo.multa
                                    FROM prestamo
                                    INNER JOIN usuario ON prestamo.usuario_id = usuario.id
                                    INNER JOIN libro ON prestamo.libro_id = libro.id");
    }
}
?>