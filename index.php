<?php
require_once 'bd.php';

$conn = db::connect();
if ($conn->connect_error) {
    die('Error de conexión a la base de datos: ' . $conn->connect_error);
}
require_once 'controlers/main_controller.php';
?>