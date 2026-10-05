<?php
class User {
    private $id_usuario;
    private string $nombre;
    private string $correo_electronico = ""; 
    private string $contraseña = "";
    private string $direccion_envio = "";

    public function __construct($id_usuario, string $nombre, ?string $contraseña = "", ?string $correo_electronico = "", ?string $direccion_envio = "")
    {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->contraseña = $contraseña ?? "";
        $this->correo_electronico = $correo_electronico ?? "";
        $this->direccion_envio = $direccion_envio ?? "";
    }

    public function getUserName() { return $this->nombre; }
    public function getEmail() { return $this->correo_electronico; }
    public function getPassword() { return $this->contraseña; }
    public function getDireccionEnvio() { return $this->direccion_envio; }
    public function getId() { return $this->id_usuario; }

    public function setUsername(string $username) {
        $this->nombre = $username;
        return $this->nombre;
    }
    public function setEmail(string $email) {
        $this->correo_electronico = $email;
        return $this->correo_electronico;
    }
    public function setPassword(string $password) {
        $this->contraseña = $password;
        return $this->contraseña;
    }
    public function setDireccionEnvio(string $direccion) {
        $this->direccion_envio = $direccion;
        return $this->direccion_envio;
    }
} 
?>