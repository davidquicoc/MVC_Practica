<?php
require_once __DIR__ . '/../config/config.php';

class Libro {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function mostrarLibros() {
        try {
            $result = $this->db->query("SELECT * FROM libro");
            if (!$result) {
                return ['error' => $this->db->error];
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function encontrarPorId($id) {
        $result = $this->db->query("SELECT * FROM libro WHERE id = '$id'");
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function añadirLibro(array $data) {
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        $genero = $data['genero'];
        $año_publicacion = $data['año_publicacion'];
        $n_paginas = $data['n_paginas'];

        return $this->db->query("INSERT INTO libro (titulo, autor, editorial, genero, año_publicacion, n_paginas) VALUES ('$titulo', '$autor', '$editorial', '$genero', '$año_publicacion', '$n_paginas')");
    }

    public function modificarLibro(array $data) {
        $id = $data['id'];
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        $genero = $data['genero'];
        $año_publicacion = $data['año_publicacion'];
        $n_paginas = $data['n_paginas'];

        return $this->db->query("UPDATE libro
            SET titulo = '$titulo',
                autor = '$autor',
                editorial = '$editorial',
                genero = '$genero',
                año_publicacion = '$año_publicacion',
                n_paginas = '$n_paginas' WHERE id = '$id'");
    }

    public function eliminarLibro($id) {
        return $this->db->query("DELETE FROM libro WHERE id = '$id'");
    }

    public function contarLibros() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    public function contarLibrosDisponibles() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro WHERE disponibilidad = 1");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    public function contarLibrosNoDisponibles() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro WHERE disponibilidad = 0");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    public function obtenerLibrosDisponibles() {
        return $this->db->query("SELECT id, titulo FROM libro WHERE disponibilidad = 1");
    }

    /*public function obtenerPrestamosDeUnUsuario($id) {
        $result = $this->db->query("SELECT libro.id, libro.titulo
                                FROM libro
                                INNER JOIN prestamo ON libro.id = prestamo.libro_id
                                WHERE prestamo.usuario_id = $id");
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }*/

    public function actualizarDisponibilidad($id, $estado) {
        $estado = (int) $estado;
        return $this->db->query("UPDATE libro SET disponibilidad = $estado WHERE id = $id");
    }
}
?>