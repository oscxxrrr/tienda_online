<?php
class ProductRepository {
    public function __construct(private mysqli $conn) {}

    // Devuelve todos los productos
    public function getAll(): array {
        $productos = [];
        $result = $this->conn->query("SELECT * FROM producto");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $this->mapToProducto($row);
            }
        }
        return $productos;
    }

    // Devuelve un producto por su ID, o null si no existe
    public function getById(int $id): ?Producto {
        $result = $this->conn->query("SELECT * FROM producto WHERE id_producto = $id");
        return ($result && $row = $result->fetch_assoc()) ? $this->mapToProducto($row) : null;
    }

    private function mapToProducto(array $row): Producto {
        return new Producto($row['id_producto'], $row['nombre'], $row['descripcion'], $row['precio_actual'], $row['stock']);
    }
}
?>
