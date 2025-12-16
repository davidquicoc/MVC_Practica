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
        $fecha_devolucion_limite = $data['fecha_devolucion_limite'];
        $multa = $data['multa'];
        
        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, fecha_devolucion_limite, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$fecha_devolucion_limite', '$multa')");
    }

    //  Devuelve TRUE/FALSE si se eliminó el préstamo correctamente en la base de datos mediante su id
    public function devolver($id) {
        $fechaHoy = date('Y-m-d');
        return $this->db->query("UPDATE prestamo
                                 SET fecha_devuelto = '$fechaHoy',
                                 devuelto = 1
                                 WHERE id = '$id'");
    }

    public function obtenerPendientes() {
        return $this->ejecutarQueryListado("WHERE p.devuelto = 0 ORDER BY p.fecha_devolucion_limite ASC");
    }

    public function obtenerHistorial() {
        return $this->ejecutarQueryListado("WHERE p.devuelto = 1 ORDER BY p.fecha_devuelto DESC");
    }

    public function obtenerActivosUsuario($idUsuario) {
        $result = $this->db->query("SELECT p.*, l.titulo
                                    FROM prestamo p
                                    INNER JOIN libro l ON p.libro_id = l.id
                                    WHERE p.usuario_id = '$idUsuario' AND p.devuelto = 0
                                    ORDER BY p.fecha_devolucion_limite ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
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
        return $this->ejecutarQueryListado("WHERE p.usuario_id = '$id' ORDER BY p.fecha_prestamo DESC");
    }

    private function ejecutarQueryListado($condicion) {
        $result = $this->db->query("SELECT p.*,
                                    u.nombre as nombre_usuario,
                                    l.titulo as titulo_libro,
                                    l.id as libro_id
                                    FROM prestamo p
                                    INNER JOIN usuario u ON p.usuario_id = u.id
                                    INNER JOIN libro l ON p.libro_id = l.id " . $condicion);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>