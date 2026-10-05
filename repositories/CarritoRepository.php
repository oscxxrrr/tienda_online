<?php
class CarritoRepository {
    private mysqli $conn;
    private int $id_usuario;

    public function __construct(mysqli $conn, int $id_usuario) {
        $this->conn = $conn;
        $this->id_usuario = $id_usuario;
    }

    // Añade un producto al carrito (o incrementa cantidad si ya existe)
    public function addProducto(int $id_producto): bool {
        $id_usuario  = $this->id_usuario;
        $id_producto = (int) $id_producto;

        // Comprueba si ya está en el carrito
        $result = $this->conn->query(
            "SELECT id_carrito_item, cantidad FROM carrito_item
             WHERE id_usuario = $id_usuario AND id_producto = $id_producto"
        );

        if ($result && $row = $result->fetch_assoc()) {
            // Ya existe: incrementa cantidad
            $nueva = $row['cantidad'] + 1;
            $id_item = $row['id_carrito_item'];
            return $this->conn->query(
                "UPDATE carrito_item SET cantidad = $nueva WHERE id_carrito_item = $id_item"
            );
        } else {
            // No existe: inserta nuevo
            return $this->conn->query(
                "INSERT INTO carrito_item (id_usuario, id_producto, cantidad)
                 VALUES ($id_usuario, $id_producto, 1)"
            );
        }
    }

    // Devuelve los items del carrito con info del producto
    public function getItems(): array {
        $id_usuario = $this->id_usuario;
        $items = [];

        $result = $this->conn->query(
            "SELECT p.id_producto, p.nombre, p.descripcion, p.precio_actual, p.stock,
                    ci.cantidad, ci.id_carrito_item
             FROM carrito_item ci
             JOIN producto p ON ci.id_producto = p.id_producto
             WHERE ci.id_usuario = $id_usuario"
        );

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = [
                    'id_carrito_item' => $row['id_carrito_item'],
                    'producto'        => new Producto(
                        $row['id_producto'],
                        $row['nombre'],
                        $row['descripcion'],
                        $row['precio_actual'],
                        $row['stock']
                    ),
                    'cantidad'        => $row['cantidad'],
                    'subtotal'        => $row['precio_actual'] * $row['cantidad']
                ];
            }
        }
        return $items;
    }

    // Elimina un item del carrito por su id_carrito_item
    public function removeItem(int $id_carrito_item): bool {
        $id_carrito_item = (int) $id_carrito_item;
        $id_usuario = $this->id_usuario;
        return $this->conn->query(
            "DELETE FROM carrito_item
             WHERE id_carrito_item = $id_carrito_item AND id_usuario = $id_usuario"
        );
    }

    // Calcula el total del carrito
    public function getTotal(): float {
        $id_usuario = $this->id_usuario;
        $result = $this->conn->query(
            "SELECT SUM(p.precio_actual * ci.cantidad) AS total
             FROM carrito_item ci
             JOIN producto p ON ci.id_producto = p.id_producto
             WHERE ci.id_usuario = $id_usuario"
        );
        if ($result && $row = $result->fetch_assoc()) {
            return (float) ($row['total'] ?? 0);
        }
        return 0.0;
    }
}
?>
