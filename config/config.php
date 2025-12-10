<?
$host = 'db';           //  Servidor: db
$user = 'root';         //  Usuario: root
$passwd = 'root';       //  Contraseña: root
$db = 'biblioteca';     //  Base de datos: biblioteca

//  Conexión con mysqli
$conn = new mysqli($host, $user, $passwd, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>