<?php
class CarritoRepository {
    public function __construct(private mysqli $conn, private int $id_usuario) {}

    // Añade un producto al carrito. Si ya existe, incrementa la cantidad
    public function addProducto(int $id_producto): void {
        $u = $this->id_usuario;
        $result = $this->conn->query(
            "SELECT id_carrito_item, cantidad FROM carrito_item WHERE id_usuario=$u AND id_producto=$id_producto"
        );
        if ($result && $row = $result->fetch_assoc()) {
            $nueva   = $row['cantidad'] + 1;
            $id_item = $row['id_carrito_item'];
            $this->conn->query("UPDATE carrito_item SET cantidad=$nueva WHERE id_carrito_item=$id_item");
        } else {
            $this->conn->query("INSERT INTO carrito_item (id_usuario, id_producto, cantidad) VALUES ($u, $id_producto, 1)");
        }
    }

    // Devuelve todos los items del carrito con la info del producto
    public function getItems(): array {
        $u      = $this->id_usuario;
        $items  = [];
        $result = $this->conn->query(
            "SELECT p.*, ci.cantidad, ci.id_carrito_item
             FROM carrito_item ci
             JOIN producto p ON ci.id_producto = p.id_producto
             WHERE ci.id_usuario = $u"
        );
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = [
                    'id_carrito_item' => $row['id_carrito_item'],
                    'producto'        => new Producto($row['id_producto'], $row['nombre'], $row['descripcion'], $row['precio_actual'], $row['stock']),
                    'cantidad'        => $row['cantidad'],
                    'subtotal'        => $row['precio_actual'] * $row['cantidad']
                ];
            }
        }
        return $items;
    }

    // Elimina un item del carrito
    public function removeItem(int $id_carrito_item): void {
        $u = $this->id_usuario;
        $this->conn->query("DELETE FROM carrito_item WHERE id_carrito_item=$id_carrito_item AND id_usuario=$u");
    }

    // Calcula el precio total del carrito
    public function getTotal(): float {
        $u      = $this->id_usuario;
        $result = $this->conn->query(
            "SELECT SUM(p.precio_actual * ci.cantidad) AS total
             FROM carrito_item ci JOIN producto p ON ci.id_producto = p.id_producto
             WHERE ci.id_usuario = $u"
        );
        return ($result && $row = $result->fetch_assoc()) ? (float)($row['total'] ?? 0) : 0.0;
    }
}
?>
