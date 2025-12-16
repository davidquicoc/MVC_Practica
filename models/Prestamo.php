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
    //  Por defecto 'devuelto' será 0 en la BD o null
    public function sacar(array $data) {
        $usuario_id = $data['usuario_id'];
        $libro_id = $data['libro_id'];
        $fecha_prestamo = $data['fecha_prestamo'];
        $fecha_devolucion = $data['fecha_devolucion'];
        $fecha_devolucion_limite = $data['fecha_devolucion_limite'];
        $multa = $data['multa'];
        
        return $this->db->query("INSERT INTO prestamo (usuario_id, libro_id, fecha_prestamo, fecha_devolucion, fecha_devolucion_limite, multa) VALUES ('$usuario_id', '$libro_id', '$fecha_prestamo', '$fecha_devolucion', '$fecha_devolucion_limite', '$multa')");
    }

    //  Devuelve TRUE/FALSE si se devolvío el libro
    //  Se registra la fecha real y se actualiza el boolean devuelto
    public function devolver($id) {
        $fechaHoy = date('Y-m-d');
        return $this->db->query("UPDATE prestamo
                                 SET fecha_devuelto = '$fechaHoy',
                                 devuelto = 1
                                 WHERE id = '$id'");
    }

    //  Obtiene préstamos activos (no devueltos) ordenados por la fecha_devolucion_limite
    public function obtenerPendientes() {
        return $this->ejecutarQueryListado("WHERE p.devuelto = 0 ORDER BY p.fecha_devolucion_limite ASC");
    }

    //  Obtiene préstamos pasados (devueltos)
    public function obtenerHistorial() {
        return $this->ejecutarQueryListado("WHERE p.devuelto = 1 ORDER BY p.fecha_devuelto DESC");
    }

    //  Obtiene los préstamos activos de un usuario específico
    //  Realiza un JOIN con 'libro' para mostrar el título en el Dashboard
    public function obtenerActivosUsuario($idUsuario) {
        $result = $this->db->query("SELECT p.*, l.titulo
                                    FROM prestamo p
                                    INNER JOIN libro l ON p.libro_id = l.id
                                    WHERE p.usuario_id = '$idUsuario' AND p.devuelto = 0
                                    ORDER BY p.fecha_devolucion_limite ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    //  Devuelve el total de préstamos
    public function contarPrestamos() {
        $result = $this->db->query("SELECT COUNT(*) AS 'total' FROM prestamo");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Obtiene todos los préstamos de un usuario (activos e históricos)
    /*public function obtenerPrestamosPorUsuario($id) {
        return $this->ejecutarQueryListado("WHERE p.usuario_id = '$id' ORDER BY p.fecha_prestamo DESC");
    }*/

    //  Método privado para evitar repetir la query SQL
    //  Hace JOINS necesarios para traer el nombre del usuario y el título del libro en lugar de solo los IDs numéricos
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