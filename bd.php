<?php
class db {
    public static function connect() {
        $conexion = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
        $conexion->set_charset("utf8mb4");
        return $conexion;
    }
}
?>