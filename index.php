<?php
// Leer el archivo .env de forma nativa sin requerir Composer
if (file_exists(__DIR__ . '/.env')) {
    $env = parse_ini_file(__DIR__ . '/.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
}

require_once 'bd.php';
$conn = db::connect();
require_once 'controlers/main_controller.php';
include 'views/mainView.phtml';
?>