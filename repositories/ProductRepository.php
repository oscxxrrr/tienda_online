<?php
class ProductRepository {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    // Devuelve un array de objetos Producto con todos los productos
    public function getAll(): array {
        $productos = [];
        $result = $this->conn->query("SELECT * FROM producto");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = new Producto(
                    $row['id_producto'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio_actual'],
                    $row['stock']
                );
            }
        }
        return $productos;
    }

    // Devuelve un único Producto por su id, o null si no existe
    public function getById(int $id): ?Producto {
        $id = (int) $id;
        $result = $this->conn->query("SELECT * FROM producto WHERE id_producto = $id");
        if ($result && $row = $result->fetch_assoc()) {
            return new Producto(
                $row['id_producto'],
                $row['nombre'],
                $row['descripcion'],
                $row['precio_actual'],
                $row['stock']
            );
        }
        return null;
    }
}
?>
