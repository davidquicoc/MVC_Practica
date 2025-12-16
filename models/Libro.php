<?php
require_once __DIR__ . '/../config/config.php';

class Libro {

    //  Objeto privado de mysqli
    private mysqli $db;

    public function __construct() {
        global $conn;
        //  Conexión a la base de datos establecida en config.php
        $this->db = $conn;
    }

    //  Devuelve todos los datos del libro y cuenta cuántos préstamos sin devolver tiene
    public function obtenerLibros() {
        try {
            $result = $this->db->query("SELECT l.*,
                                        (SELECT COUNT(*) FROM prestamo p WHERE p.libro_id = l.id AND devuelto = 0) AS prestamos_pendientes,
                                        (SELECT COUNT(*) FROM prestamo p WHERE p.libro_id = l.id AND devuelto = 1) AS prestamos_devueltos
                                        FROM libro l");
            if (!$result) {
                return ['error' => $this->db->error];
            }
            //  Array asociativo con todas las filas
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    //  Devuelve TRUE/FALSE si se insertó el libro a la base de datos con sus datos pasados en $data
    public function añadirLibro(array $data) {
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        $genero = $data['genero'];
        $año_publicacion = $data['año_publicacion'];
        $n_paginas = $data['n_paginas'];

        return $this->db->query("INSERT INTO libro (titulo, autor, editorial, genero, año_publicacion, n_paginas) VALUES ('$titulo', '$autor', '$editorial', '$genero', '$año_publicacion', '$n_paginas')");
    }

    //  Actualiza un libro
    //  Retorna: 2 (Modificado), 1 (Sin cambios), 0 (Error)
    public function modificarLibro(array $data) {
        $id = $data['id'];
        $titulo = $data['titulo'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        $genero = $data['genero'];
        $año_publicacion = $data['año_publicacion'];
        $n_paginas = $data['n_paginas'];

        //  Se verifica si los datos son diferentes a los que ya existen
        $comparacion = (new Libro())->compararLibro($data);

        //  Hay diferencias, se actualiza el libro 
        if ($comparacion == 2) {
            $result = $this->db->query("UPDATE libro
                SET titulo = '$titulo',
                autor = '$autor',
                editorial = '$editorial',
                genero = '$genero',
                año_publicacion = '$año_publicacion',
                n_paginas = '$n_paginas' WHERE id = '$id'");
                return $result ? 2 : 0;
        }
        //  Los datos del libro son idénticos
        if ($comparacion == 1) return 1;
        return 0;
    }
    
    //  Devuelve TRUE/FALSE si se eleminó el libro correctamente en la base de datos mediante su id
    public function eliminarLibro($id) {
        return $this->db->query("DELETE FROM libro WHERE id = '$id'");
    }

    //  Devuelve en número entero, el total de libros en la base de datos
    public function contarLibros() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Devuelve en número entero, el total de libros en la base de datos según la disponibilidad pasada por el parámetro
    //  (1 = Disponible, 0 = Prestado)
    public function contarLibrosSegunDisponibilidad($numDisponibilidad) {
        $result = $this->db->query("SELECT COUNT(*) as total FROM libro WHERE disponibilidad = $numDisponibilidad");
        if ($result) {
            $fila = $result->fetch_assoc();
            return $fila['total'];
        }
        return 0;
    }

    //  Devuelve el ID y titulo de los libros disponibles
    //  Se usa en el <select> de formulario de préstamos
    public function obtenerIdTituloDeLibrosDisponibles() {
        $result = $this->db->query("SELECT id, titulo FROM libro WHERE disponibilidad = 1");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    //  Devuelve TRUE/FALSE si se actualizó la disponibilidad de un libro a la base de datos
    public function actualizarDisponibilidad($id, $estado) {
        $estado = (int) $estado;
        return $this->db->query("UPDATE libro SET disponibilidad = $estado WHERE id = $id");
    }

    //  Función que verifica si se va a realizar un UPDATE
    //  Compara los datos del formulario $data con los de la BD
    private function compararLibro(array $data)  {
        $idData = $data['id'];
        $result = $this->db->query("SELECT * FROM libro WHERE id = $idData");
        if ($result && $result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            if ($fila['titulo'] == $data['titulo'] && $fila['autor'] == $data['autor']
                && $fila['editorial'] == $data['editorial'] && $fila['genero'] == $data['genero']
                && $fila['año_publicacion'] == $data['año_publicacion'] && $fila['n_paginas'] == $data['n_paginas']
                ) {
                return 1;   //  Iguales
            } else {
                return 2;   //  Distintos
            }
        }
        return 0;   //  No existe
    }
}
?>