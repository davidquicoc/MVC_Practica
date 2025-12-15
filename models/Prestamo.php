<?php
require_once __DIR__ . '/../config/config.php';

class Prestamo {

    //  Objeto privado de mysqli
    private mysqli $db;

    public function __construct() {
        global $conn;
        //  Conexión a la base de datos establecida en config.php
        $this->db = $conn;
    }

    //  Devuelve TRUE/FALSE si se insertó el préstamo a la base de datos con sus datos pasados en $data
    public function sacar(array $data) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];
        $fecha_devolucion = $data['fecha_devolucion'];
        $multa = $data['multa'];
        
        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$multa')");
    }

    //  Devuelve TRUE/FALSE si se eliminó el préstamo correctamente en la base de datos mediante su id
    public function devolver($id) {
        return $this->db->query("DELETE FROM prestamo WHERE id = '$id'");
    }

    //  Devuelve un array asociativo con todos los préstamos o NULL si ocurre un error
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
        if ($result) return $result->fetch_all(MYSQLI_ASSOC);
        return [];
    }

    //  Devuelve en número entero, el total de préstamos en la base de datos
    public function contarPrestamos() {
        $result = $this->db->query("SELECT COUNT(*) AS 'total' FROM prestamo");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Devuelve en un array asociativo con todos los préstamos del usuario indicado por $id, o devuelve un array vacío 
    public function obtenerPrestamosPorUsuario($id) {
        $result = $this->db->query("SELECT p.id AS prestamo_id,
                                    p.fecha_prestamo,
                                    p.fecha_devolucion,
                                    p.multa,
                                    l.titulo
                                    FROM prestamo p
                                    INNER JOIN libro l ON p.libro_id = l.id
                                    WHERE p.usuario_id = '$id'");
        if ($result) return $result->fetch_all(MYSQLI_ASSOC);
        return [];
    }
}
?>