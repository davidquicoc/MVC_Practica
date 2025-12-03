<?php
require_once __DIR__ . '/../config/config.php';

class Libro {
    private mysqli $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }    
}
?>