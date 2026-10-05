<?php
    require_once 'models/user.php';
    require_once 'models/producto.php';
    require_once 'models/carrito.php';
    
    session_start();

    // LOGIN 
    if(isset($_POST['username']) && isset($_POST['password'])){
        $q = "SELECT * FROM usuarios WHERE nombre='" . $_POST['username'] . "'";
        $result = $conexion->query($q);
        
        if($result && $row = $result->fetch_assoc()){
            if(md5($_POST['password']) == $row['contrasena']){
                $_SESSION['user'] = new User($row['id'], $row['nombre'], $row['contrasena'], $row['email']);
                header("Location: index.php");
                exit();
            } else {
                $info = "Contraseña incorrecta <br>";
            }
        } else {
            $info = "Usuario no encontrado <br>";
        }
    }
?>