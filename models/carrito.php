<?php
    class Carrito {
        private $id_carrito_item;
        private $id_usuario;
        private $id_producto;
        private int $cantidad;
        private string $fecha_agregado;

        public function __construct($id_carrito_item, $id_usuario, $id_producto, int $cantidad, string $fecha_agregado) { 
            $this->id_usuario = $id_usuario;
            $this->id_producto = $id_producto;
            $this->cantidad = $cantidad;
            $this->fecha_agregado = $fecha_agregado;
        }

        public function getIdCarritoItem() {
            return $this->id_carrito_item;
        }

        public function getIdUsuario() {
            return $this->id_usuario;
        }

        public function getIdProducto() {
            return $this->id_producto;
        }

        public function getCantidad() {
            return $this->cantidad;
        }

        public function getFechaAgregado() {
            return $this->fecha_agregado;
        }
    }
?>