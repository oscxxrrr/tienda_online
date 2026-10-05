<?php
    // Los modelos ya se cargan en index.php (antes de session_start)
    require_once 'repositories/ProductRepository.php';
    require_once 'repositories/CarritoRepository.php';

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

    // Repositorios (solo si hay sesión)
    $productRepo  = new ProductRepository($conexion);
    $productArray = $productRepo->getAll();

    $carritoItems = [];
    $carritoTotal = 0.0;
    $carritoRepo  = null;

    if(isset($_SESSION['user'])){
        $carritoRepo = new CarritoRepository($conexion, $_SESSION['user']->getId());

        // AÑADIR AL CARRITO
        if(isset($_GET['accion']) && $_GET['accion'] === 'addCarrito' && isset($_GET['id'])){
            $carritoRepo->addProducto((int)$_GET['id']);
            header("Location: index.php");
            exit();
        }

        // ELIMINAR DEL CARRITO
        if(isset($_GET['accion']) && $_GET['accion'] === 'removeCarrito' && isset($_GET['item'])){
            $carritoRepo->removeItem((int)$_GET['item']);
            header("Location: index.php");
            exit();
        }

        // VER CARRITO
        if(isset($_GET['accion']) && $_GET['accion'] === 'carrito'){
            $carritoItems = $carritoRepo->getItems();
            $carritoTotal = $carritoRepo->getTotal();
        }
    }
?>