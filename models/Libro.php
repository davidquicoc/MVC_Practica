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
            $result = $this->db->query("SELECT id, titulo, autor FROM libro");
            if (!$result) {
                return ['error' => $this->db->error];
            }
            return $result->fetch_assoc();
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

    public function añadirLibro() {}

    public function cambiarLibro() {}
}
?>