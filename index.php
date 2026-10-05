<?php
// Cargar modelos ANTES de session_start() para que PHP pueda
// deserializar los objetos almacenados en sesión
require_once 'models/user.php';
require_once 'models/producto.php';
require_once 'models/carrito.php';
require_once 'repositories/ProductRepository.php';
require_once 'repositories/CarritoRepository.php';
require_once 'repositories/UserRepository.php';

session_start();

// Leer el archivo .env de forma nativa sin requerir Composer
if (file_exists(__DIR__ . '/.env')) {
    $env = parse_ini_file(__DIR__ . '/.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
}

require_once 'bd.php';
$conexion = db::connect();
require_once 'controlers/main_controller.php';
include 'views/mainView.phtml';
?>