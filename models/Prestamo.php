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

    public function listarPrestamos() {
        $result = $this->db->query("SELECT p.id AS prestamo_id,
                                    u.nombre AS nombre_usuario,
                                    l.titulo AS titulo_libro,
                                    l.id AS libro_id,
                                    p.fecha_prestamo,
                                    p.fecha_devolucion,
                                    p.multa
                                    FROM prestamo p
                                    INNER JOIN usuario u ON p.usuario_id = u.id
                                    INNER JOIN libro l ON p.libro_id = l.id");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return 0;
    }

    public function totalDePrestamosExistentes() {
        $result = $this->db->query("SELECT COUNT(*) AS 'total' FROM prestamo");
        if ($result) {
            return $result->fetch_assoc();
        }
        return 0;
    }

    public function obtenerPrestamosPorUsuario($id) {
        $result = $this->db->query("SELECT p.id AS prestamo_id,
                                    p.fecha_prestamo,
                                    l.titulo,
                                    p.fecha_devolucion,
                                    p.multa
                                    FROM prestamo p
                                    INNER JOIN libro l ON p.libro_id = l.id
                                    WHERE p.usuario_id = $id");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
?>