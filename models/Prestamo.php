<?php
require_once __DIR__ . '/../config/config.php';

class Prestamo {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    //  Función que inserta un préstamos con los datos del array
    public function sacar(array $data) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];
        $fecha_devolucion = $data['fecha_devolucion'];
        $multa = $data['multa'];
        
        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$multa')");
    }

    public function devolver($id) {
        return $this->db->query("DELETE FROM prestamo WHERE id = '$id'");
    }

    //  Función que listará todos los préstamos
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

    //  Función que devuelve el total de préstamos existentes en la base de datos
    public function contarPrestamos() {
        $result = $this->db->query("SELECT COUNT(*) AS 'total' FROM prestamo");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Función que devuelve los préstamos mediante el id de un usuario
    public function obtenerPrestamosPorUsuario($id) {
        $result = $this->db->query("SELECT p.id AS prestamo_id,
                                    p.fecha_prestamo,
                                    p.fecha_devolucion,
                                    p.multa,
                                    l.titulo
                                    FROM prestamo p
                                    INNER JOIN libro l ON p.libro_id = l.id
                                    WHERE p.usuario_id = '$id'");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
?>