<?php
    require_once 'models/user.php';
    require_once 'models/producto.php';
    require_once 'models/carrito.php';
    
    session_start();

    if(isset($_GET['accion']) && $_GET['accion'] == 'logout'){
        session_unset();
        header("Location: index.php");
        exit();
    }

    
?>