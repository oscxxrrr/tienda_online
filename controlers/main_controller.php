<?php
    // Los modelos ya se cargan en index.php (antes de session_start)

    // LOGOUT
    if(isset($_GET['accion']) && $_GET['accion'] === 'logout'){
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // LOGIN (solo si NO viene el campo 'register')
    if(isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['register'])){
        $q = "SELECT * FROM usuario WHERE nombre='" . $conexion->real_escape_string($_POST['username']) . "'";
        $result = $conexion->query($q);

        if($result && $row = $result->fetch_assoc()){
            if(md5($_POST['password']) == $row['contrasena']){
                $_SESSION['user'] = new User(
                    $row['id_usuario'],
                    $row['nombre'],
                    $row['contrasena'],
                    $row['correo_electronico'],
                    $row['direccion_envio']
                );
                header("Location: index.php");
                exit();
            } else {
                $info = "Contraseña incorrecta <br>";
            }
        } else {
            $info = "Usuario no encontrado <br>";
        }
    }

    // REGISTRO
    if(isset($_POST['register']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
        $nombre     = $conexion->real_escape_string($_POST['username']);
        $email      = $conexion->real_escape_string($_POST['email']);
        $contrasena = md5($_POST['password']);

        $q = "INSERT INTO usuario (nombre, correo_electronico, contrasena) VALUES ('$nombre', '$email', '$contrasena')";

        if($conexion->query($q)){
            $info = "¡Registro exitoso! Ya puedes iniciar sesión.";
        } else {
            $info = "Error al registrar: " . $conexion->error;
        }
    }

    // PRODUCTOS
    $productArray = [];
    $resultado = $conexion->query("SELECT * FROM producto");

    if($resultado){
        while($row = $resultado->fetch_assoc()){
            $productArray[] = new Producto(
                $row['id_producto'],
                $row['nombre'],
                $row['descripcion'],
                $row['precio_actual'],
                $row['stock']
            );
        }
    }
?>