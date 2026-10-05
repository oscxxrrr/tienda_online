<?php
    class Producto {
        private $id;
        private $nombre;
        private $descripcion;
        private $precio_actual;
        private $stock;

        public function __construct($id, $nombre, $descripcion, $precio_actual, $stock) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio_actual = $precio_actual;
            $this->stock = $stock;
        }

        public function getId() {
            return $this->id;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function getPrecioActual() {
            return $this->precio_actual;
        }

        public function getStock() {
            return $this->stock;
        }
    }
?>