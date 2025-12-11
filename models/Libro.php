<?php
require_once __DIR__ . '/../config/config.php';

class Libro {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    //  Función que muestra todos los libros en un array asociativo
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

    //  Función que añadirá un libro a la base de datos
    public function añadirLibro(array $data) {
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        $genero = $data['genero'];
        $año_publicacion = $data['año_publicacion'];
        $n_paginas = $data['n_paginas'];

        return $this->db->query("INSERT INTO libro (titulo, autor, editorial, genero, año_publicacion, n_paginas) VALUES ('$titulo', '$autor', '$editorial', '$genero', '$año_publicacion', '$n_paginas')");
    }

    //  Función que modificará un libro de la base de datos
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

    //  Función que eliminará un libro de la base de datos
    public function eliminarLibro($id) {
        return $this->db->query("DELETE FROM libro WHERE id = '$id'");
    }

    //  Función que cuenta el total de libros existentes en la base de datos
    public function contarLibros() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    public function contarLibrosSegunDisponibilidad($numDisponibilidad) {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro WHERE disponibilidad = $numDisponibilidad");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Función que obtiene el id y titulo de los libros con disponibilidad
    public function obtenerLibrosDisponibles() {
        return $this->db->query("SELECT id, titulo FROM libro WHERE disponibilidad = 1");
    }

    //  Función que actualiza la disponibilidad de un libro
    public function actualizarDisponibilidad($id, $estado) {
        $estado = (int) $estado;
        return $this->db->query("UPDATE libro SET disponibilidad = $estado WHERE id = $id");
    }
}
?>