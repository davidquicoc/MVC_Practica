<?
$host = 'db';
$user = 'root';
$passwd = 'root';
$db = 'biblioteca';

$conn = new mysqli($host, $user, $passwd, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>