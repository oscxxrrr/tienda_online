<?php
class UserRepository {
    public function __construct(private mysqli $conn) {}

    public function getByUsername(string $nombre): ?User {
        $nombre = $this->conn->real_escape_string($nombre);
        $result = $this->conn->query("SELECT * FROM usuario WHERE nombre = '$nombre' LIMIT 1");
        return ($result && $row = $result->fetch_assoc()) ? $this->mapToUser($row) : null;
    }

    public function getById(int $id): ?User {
        $result = $this->conn->query("SELECT * FROM usuario WHERE id_usuario = $id LIMIT 1");
        return ($result && $row = $result->fetch_assoc()) ? $this->mapToUser($row) : null;
    }

    public function getByEmail(string $email): ?User {
        $email = $this->conn->real_escape_string($email);
        $result = $this->conn->query("SELECT * FROM usuario WHERE correo_electronico = '$email' LIMIT 1");
        return ($result && $row = $result->fetch_assoc()) ? $this->mapToUser($row) : null;
    }

    // Registra un nuevo usuario. Devuelve el User creado o null si falla
    public function create(string $nombre, string $email, string $password): ?User {
        $nombre     = $this->conn->real_escape_string($nombre);
        $email      = $this->conn->real_escape_string($email);
        $contrasena = md5($password);
        $ok = $this->conn->query(
            "INSERT INTO usuario (nombre, correo_electronico, contrasena) VALUES ('$nombre', '$email', '$contrasena')"
        );
        return $ok ? $this->getById($this->conn->insert_id) : null;
    }

    // Verifica usuario y contraseña. Devuelve User si es correcto, null si no
    public function login(string $nombre, string $password): ?User {
        $user = $this->getByUsername($nombre);
        return ($user && md5($password) === $user->getPassword()) ? $user : null;
    }

    // Actualiza nombre, email y dirección del usuario
    public function update(User $user): bool {
        $id        = $user->getId();
        $nombre    = $this->conn->real_escape_string($user->getUserName());
        $email     = $this->conn->real_escape_string($user->getEmail());
        $direccion = $this->conn->real_escape_string($user->getDireccionEnvio());
        return (bool) $this->conn->query(
            "UPDATE usuario SET nombre='$nombre', correo_electronico='$email', direccion_envio='$direccion' WHERE id_usuario=$id"
        );
    }

    private function mapToUser(array $row): User {
        return new User($row['id_usuario'], $row['nombre'], $row['contrasena'], $row['correo_electronico'], $row['direccion_envio']);
    }
}
?>
