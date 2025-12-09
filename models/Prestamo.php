<?php
require_once __DIR__ . '/../config/config.php';

class Prestamo {
    private mysqli $db;


    public function __construct() {
        global $conn;
        $this->db = $conn;
    }
}
?>