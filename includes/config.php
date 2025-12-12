<?php
// includes/config.php - Sin session_start
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'lbgym';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>